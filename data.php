<?php
require './requires/header.php';
require './requires/mysql.php';
?>		
		<aside>
		</aside>
		<main>
			<!--article for formal data-->
			<article>
				<header>
					<h2>Formale Daten</h2>
				</header>
				<?php
				//load scripts
				echo '<script crossorigin="anonymous" src="https://cdn.bokeh.org/bokeh/release/bokeh-2.2.3.min.js"></script>';
				echo '<script crossorigin="anonymous" src="https://cdn.bokeh.org/bokeh/release/bokeh-api-2.2.3.min.js"></script>';
				
				//prepare sql-query
				$getName = $conn->prepare("SELECT name,strasse,plz,ort,vorwahl,tel,url,öffnungszeiten,bestandsgrößenklasse,unterhaltsträger,dbv,leitung FROM bibs_data_table where dbsid= ?");
				$getName->execute(array($_GET['id']));

				//table of formal data
				if ($getName->rowCount() > 0) {
					$row = $getName->fetch(PDO::FETCH_ASSOC);
					$lib_name = $row["name"];
				?>
				<table>
					<thead>
						<tr>
							<th id="contact" scope="col">Kontakt</th>
							<th id="openingHours" scope="col">Öffnungszeiten</th>
							<th id="informations" scope="col">Weitere Informationen</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td headers="contact" class="formalData"><?php echo $row["name"].'<br>'.$row["strasse"].'<br>'.$row["plz"].' '.$row["ort"].'<br>Tel: '.$row["vorwahl"].' '.$row["tel"].'<br>Web: <a href="'.$row["url"].'">'.$row["url"].'</a>'; ?></td>
							<td headers="openingHours" class="formalData"><?php echo $row["öffnungszeiten"]; ?></td>
							<td headers="informations" class="formalData">Bestandsgrößenklasse: <?php echo $row["bestandsgrößenklasse"].'<br>Unterhaltsträger: '.$row["unterhaltsträger"]."<br>DBV: ".$row["dbv"]."<br>Leitung: ".$row["leitung"]; ?></td>
						</tr>
					</tbody>
				</table>
				<?php
				} else {
					echo "<strong>Nichts gefunden!</strong>";
				}
				?>
			</article>

			<!--article for radar chart-->
			<article>
				<header>
					<h2>Netzdiagramm</h2>
				</header>
				
				<!--data preparation-->
				<?php
				$operating_figures = array (
					'B.1.3.1' => 'Nutzungsfläche zu Primärnutzerschaft',
					'B.1.3.2' => 'Arbeitsplätze zu Primärnutzerschaft',
					'B.1.4.1' => 'Personal zu Primärnutzerschaft',
					'B.2.2.1' => 'Bibliotheksbesuche zu Primärnutzerschaft',
					'B.2.2.5' => 'Schulungsbesuche zu Primärnutzerschaft',
					'B.3.1.2' => 'Erwerbungskosten pro Bestandsnutzung',
					'B.3.4.1' => 'Kosten pro aktiv Nutzende',
					'B.4.2.3' => 'Schulungsstunden zu Bruttoarbeitszeit',
					'B.4.3.1' => 'Sonderzuschüsse und selbst generierte Einnahmen zu Gesamtbudget'
				);

				$quarts = array (
					'I' => 'Ressourcen, Zugang und Infrastruktur',
					'II' => 'Nutzung',
					'III' => 'Effizienz',
					'IV' => 'Potenziale und Entwicklung'
				);

				$min = array (); 
				$med = array (); 
				$max = array (); 
				$val = array (); 
				foreach (array_reverse(array_keys($operating_figures)) as $value) {
					if ($value != 'B.1.3.1') {
						$getMinValue = $conn->query("SELECT MIN(`$value`) as MINIMUM FROM operating_figures_view WHERE cyear = (SELECT MAX(cyear) FROM operating_figures_view)");
						$minValue = $getMinValue->fetch();
						array_push($min, $minValue["MINIMUM"]);

						$prepareMedValue = $conn->prepare("CALL QUANTILE_COUNT((SELECT MAX(cyear) FROM operating_figures_view), '`$value`', 0.50, @outputValue)");
						$prepareMedValue->execute();
						$getMedValue = $conn->query("SELECT @outputValue");
						$medValue = $getMedValue->fetchColumn();
						array_push($med, $medValue);

						$getMaxValue = $conn->query("SELECT MAX(`$value`) as MAXIMUM FROM operating_figures_view WHERE cyear = (SELECT MAX(cyear) FROM operating_figures_view)");
						$maxValue = $getMaxValue->fetch();
						array_push($max, $maxValue["MAXIMUM"]);

						$getCoreData = $conn->prepare("SELECT `$value` as ACTUAL FROM operating_figures_view WHERE cyear = (SELECT MAX(cyear) FROM operating_figures_view) AND dbsid= ?");
						$getCoreData->execute(array($_GET['id']));
						if ($getCoreData->rowCount() == 1) {
									$actualValue = $getCoreData->fetch(PDO::FETCH_ASSOC);
							array_push($val, $actualValue["ACTUAL"]);
						}
					}   
				}
				?>
				
				<div class="container">
					<!--radar chart-->
					<figure id="radarchart">
						<script src="js/charts.js"></script>
						<script>
							<?php
							$getBibName = $conn->prepare("SELECT bname FROM raw_data_table WHERE cyear = (SELECT MAX(cyear) FROM raw_data_table) AND dbsid= ?");
							$getBibName->execute(array($_GET['id']));

							if ($getBibName->rowCount() == 1) {
								$row = $getBibName->fetch(PDO::FETCH_ASSOC);
								echo 'CHARTS.init(['.json_encode($min).','.json_encode($max).','.json_encode($med).','.json_encode($val).','.json_encode($row["bname"]).']);';
							} else {
								echo 'CHARTS.init(['.json_encode($min).','.json_encode($max).','.json_encode($med).']);';
							}
							?>
							CHARTS.radarchart();
						</script>
					</figure>

					<!--legend table for radar chart-->
					<table>
						<thead>
							<tr>
								<th id="number" scope="col">Nummer</th>
								<th id="name" scope="col">Name</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$counter = 1;
							foreach ($quarts as $key => $value) {
								echo '<tr class="subheading">';
									echo '<td headers="number" class="legend">'.$key.'</td>';
									echo '<td headers="name" class="legend">'.$value.'</td>';
								echo '</tr>';
								do {
									echo '<tr>';
										echo '<td headers="number" class="legend">'.array_keys($operating_figures)[$counter].'</td>';
										echo '<td headers="name" class="legend">'.array_values($operating_figures)[$counter].'</td>';
									echo '</tr>';
								} while (++$counter%2 != 1);
							}
							?>
						<tbody>
					</table>
				</div>
				<br>

				<!--data table for radar chart-->
				<?php
				$getCoreData = $conn->prepare("SELECT `B.1.3.2`, `B.1.4.1`, `B.2.2.1`, `B.2.2.5`, `B.3.1.2`, `B.3.4.1`, `B.4.2.3`, `B.4.3.1` FROM operating_figures_view WHERE cyear=(SELECT MAX(cyear) FROM operating_figures_view) AND dbsid= ?");
				$getCoreData->execute(array($_GET['id']));
				$row = $getCoreData->fetch(PDO::FETCH_ASSOC);
				?>
				<table>
					<thead>
						<tr>
							<td rowspan="2"></td>
							<th scope="colgroup" colspan="2">I</th>
							<th scope="colgroup" colspan="2">II</th>
							<th scope="colgroup" colspan="2">III</th>
							<th scope="colgroup" colspan="2">IV</th>
						</tr>
						<tr>
							<th id="B.1.3.2" scope="col">B.1.3.2</th>
							<th id="B.1.4.1" scope="col">B.1.4.1</th>
							<th id="B.2.2.1" scope="col">B.2.2.1</th>
							<th id="B.2.2.5" scope="col">B.2.2.5</th>
							<th id="B.3.1.2" scope="col">B.3.1.2</th>
							<th id="B.3.4.1" scope="col">B.3.4.1</th>
							<th id="B.4.2.3" scope="col">B.4.2.3</th>
							<th id="B.4.3.1" scope="col">B.4.3.1</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th class="rowHeading">
								<?php
								if (isset($lib_name)) {
									echo $lib_name;
								} else {
									echo '-';
								};
								?>
							</th>
							<td headers="B.1.3.2">
								<?php
								if (isset($row["B.1.3.2"])) {
									echo number_format($row["B.1.3.2"], 0, ',', '.');
								} else {
									echo '-';
								};
								?>
							</td>
							<td headers="B.1.4.1">
								<?php
								if (isset($row["B.1.4.1"])) {
									echo number_format($row["B.1.4.1"], 0, ',', '.');
								} else {
									echo '-';
								};
								?>
							</td>
							<td headers="B.2.2.1">
								<?php
								if (isset($row["B.2.2.1"])) {
									if ($row["B.2.2.1"] < 10) {
										echo number_format($row["B.2.2.1"], 1, ',', '.');
									} else {
										echo number_format($row["B.2.2.1"], 0, ',', '.');
									}
								} else {
									echo '-';
								};
								?>
							</td>
							<td headers="B.2.2.5">
								<?php
								if (isset($row["B.2.2.5"])) {
									echo number_format($row["B.2.2.5"], 0, ',', '.');
								} else {
									echo '-';
								};
								?>
							</td>
							<td headers="B.3.1.2">
								<?php
								if (isset($row["B.3.1.2"])) {
									echo number_format($row["B.3.1.2"], 2, ',', '.');
								} else {
									echo '-';
								};
								?>
							</td>
							<td headers="B.3.4.1">
								<?php
								if (isset($row["B.3.4.1"])) {
									echo number_format($row["B.3.4.1"], 2, ',', '.');
								} else {
									echo '-';
								};
								?>
							</td>
							<td headers="B.4.2.3">
								<?php
								if (isset($row["B.4.2.3"])) {
									echo number_format($row["B.4.2.3"], 1, ',', '.');
								} else {
									echo '-';
								};
								?>
							</td>
							<td headers="B.4.3.1">
								<?php
								if (isset($row["B.4.3.1"])) {
									echo number_format($row["B.4.3.1"], 1, ',', '.');
								} else {
									echo '-';
								};
								?>
							</td>
						</tr>
						<tr>
							<th class="rowHeading">Median</th>
							<td headers="B.1.3.2"><?php echo number_format($med[7], 0, ',', '.'); ?></td>
							<td headers="B.1.4.1"><?php echo number_format($med[6], 0, ',', '.'); ?></td>
							<td headers="B.2.2.1">
								<?php
								if ($med[5] < 10) {
									echo number_format($med[5], 1, ',', '.');
								} else {
									echo number_format($med[5], 0, ',', '.');
								}
								?>
							</td>
							<td headers="B.2.2.5"><?php echo number_format($med[4], 0, ',', '.'); ?></td>
							<td headers="B.3.1.2"><?php echo number_format($med[3], 2, ',', '.'); ?></td>
							<td headers="B.3.4.1"><?php echo number_format($med[2], 2, ',', '.'); ?></td>
							<td headers="B.4.2.3"><?php echo number_format($med[1], 1, ',', '.'); ?></td>
							<td headers="B.4.3.1"><?php echo number_format($med[0], 1, ',', '.'); ?></td>
						</tr>
					</tbody>
				</table>
			</article>

			<!--article for boxplots-->
			<article>
				<header>
					<h2>Kennzahlen-Zeitreihen</h2>
				</header>

				<!--data table for boxplots-->
				<?php
				$counter = 0;

				$precision = array (
					'B.1.3.1' => 0,
					'B.1.3.2' => 0,
					'B.1.4.1' => 0,
					'B.2.2.1' => 1,
					'B.2.2.5' => 0,
					'B.3.1.2' => 2,
					'B.3.4.1' => 2,
					'B.4.2.3' => 1,
					'B.4.3.1' => 1
				);

				foreach ($operating_figures as $key => $value) {
					$boxesData = array();
					$whiskersData = array();
					$outliersData = array();
					$libraryData = array();

					$getYearList = $conn->prepare("SELECT DISTINCT(cyear) FROM raw_data_table ORDER BY cyear");
					$getYearList->execute();
					$yearList = $getYearList->fetchAll(PDO::FETCH_COLUMN, 0);

					foreach ($yearList as $curYear) {
						$quantList = array (); 
						foreach ([0.25, 0.5, 0.75] as $i) {
							$getQuantile = $conn->prepare("CALL QUANTILE_COUNT($curYear, '`$key`', $i, @outputValue)");
							$getQuantile->execute();
							$getQuantile = $conn->query("SELECT @outputValue");
							$quantileValue = $getQuantile->fetchColumn();
							array_push($quantList, $quantileValue);
						}   
						$boxesData[$curYear] = $quantList;

						$getBottomWhiskers = $conn->prepare("SELECT MAX(WHISKER) FROM (SELECT ($quantList[0]-(1.5*($quantList[2]-$quantList[0]))) AS WHISKER UNION SELECT MIN(`$key`) AS WHISKER FROM operating_figures_view WHERE cyear=$curYear) s");
						if ($getBottomWhiskers->execute()) {
							$bottomWhisker = $getBottomWhiskers->fetch(PDO::FETCH_COLUMN, 0);
						} else {
							$bottomWhisker = NULL;
						}
						
						$getTopWhiskers = $conn->prepare("SELECT MIN(WHISKER) FROM (SELECT ($quantList[2]+(1.5*($quantList[2]-$quantList[0]))) AS WHISKER UNION SELECT MAX(`$key`) AS WHISKER FROM operating_figures_view WHERE cyear=$curYear) s");
						if ($getTopWhiskers->execute()) {
							$topWhisker = $getTopWhiskers->fetch(PDO::FETCH_COLUMN, 0);
						} else {
							$topWhisker = NULL;
						} 
						$whiskersData[$curYear] = [$bottomWhisker, $topWhisker];
					
						$getBottomOutliers = $conn->prepare("SELECT `$key` FROM operating_figures_view WHERE `$key`<$bottomWhisker AND cyear=$curYear ORDER BY `$key`");
						if ($getBottomOutliers->execute()) {
							$bottomOutliers = $getBottomOutliers->fetchAll(PDO::FETCH_COLUMN, 0);
						}
					
						$getTopOutliers = $conn->prepare("SELECT `$key` FROM operating_figures_view WHERE `$key`>$topWhisker AND cyear=$curYear ORDER BY `$key`");
						if ($getTopOutliers->execute()) {
							$topOutliers = $getTopOutliers->fetchAll(PDO::FETCH_COLUMN, 0);
						} else {
							$topOutliers = array();
						}
						$outliersData[$curYear] = array_merge($bottomOutliers, $topOutliers);

						$getLibraryPoints = $conn->prepare("SELECT `$key` FROM operating_figures_view WHERE dbsid=? AND cyear=$curYear");
						$getLibraryPoints->execute(array($_GET['id']));
						$libraryData[$curYear] = $getLibraryPoints->fetchAll(PDO::FETCH_COLUMN, 0);
					}
					?>
					<section>
						<h3><?php echo $key.': '.$value; ?></h3>

						<div class="container">
							<div id="boxplot_<?php echo $counter; ?>" style="text-align:center; margin:auto; display:inline-block;"></div>
						</div>
						<br>
						<figure>
							<script>
								CHARTS.init([<?php echo json_encode($counter).','.json_encode($boxesData).','.json_encode($whiskersData).','.json_encode($outliersData).','.json_encode($libraryData) ?>])
								CHARTS.boxplot();
							</script>
						</figure>
						
						<table>
							<thead>
								<tr>
									<td></td>
									<?php
									foreach ($yearList as $curYear) {echo '<th id="'.$key.'_'.$curYear.'" scope="col">'.$curYear.'</th>';}
									?>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php
									if (isset($lib_name)) {
										echo '<th scope="row" class="rowHeading">'.$lib_name.'</th>';
										foreach ($yearList as $curYear) {
											if (isset ($libraryData[$curYear][0])) {
												echo '<td headers="'.$key.'_'.$curYear.'">'.number_format($libraryData[$curYear][0], $precision[$key], ',', '.').'</td>';
											} else {
												echo '<td headers="'.$key.'_'.$curYear.'">-</td>';
											}
										}
									}
									?>
								</tr>								
								<tr>
									<th scope="row" class="rowHeading">Oberer Fühler</th>
									<?php
									foreach ($yearList as $curYear) {
										if (isset ($whiskersData[$curYear][1])) {
											echo '<td headers="'.$key.'_'.$curYear.'">'.number_format($whiskersData[$curYear][1], $precision[$key], ',', '.').'</td>';
										} else {
											echo '<td headers="'.$key.'_'.$curYear.'">-</td>';
										}
									}
									?>
								</tr>
								<tr>
									<th scope="row" class="rowHeading">Oberes Quartil</th>
									<?php
									foreach ($yearList as $curYear) {
										if (isset ($boxesData[$curYear][2])) {
											echo '<td headers="'.$key.'_'.$curYear.'">'.number_format($boxesData[$curYear][2], $precision[$key], ',', '.').'</td>';
										} else {
											echo '<td headers="'.$key.'_'.$curYear.'">-</td>';
										}
									}
									?>
								</tr>
								<tr>
									<th scope="row" class="rowHeading">Median</th>
									<?php
									foreach ($yearList as $curYear) {
										if (isset ($boxesData[$curYear][1])) {
											echo '<td headers="'.$key.'_'.$curYear.'">'.number_format($boxesData[$curYear][1], $precision[$key], ',', '.').'</td>';
										} else {
											echo '<td headers="'.$key.'_'.$curYear.'">-</td>';
										}
									}
									?>
								</tr>
								<tr>
									<th scope="row" class="rowHeading">Unteres Quartil</th>
									<?php
									foreach ($yearList as $curYear) {
										if (isset ($boxesData[$curYear][0])) {
											echo '<td headers="'.$key.'_'.$curYear.'">'.number_format($boxesData[$curYear][0], $precision[$key], ',', '.').'</td>';
										} else {
											echo '<td headers="'.$key.'_'.$curYear.'">-</td>';
										}
									}
									?>
								</tr>
								<tr>
									<th scope="row" class="rowHeading">Unterer Fühler</th>
									<?php
									foreach ($yearList as $curYear) {
										if (isset ($whiskersData[$curYear][0])) {
											echo '<td headers="'.$key.'_'.$curYear.'">'.number_format($whiskersData[$curYear][0], $precision[$key], ',', '.').'</td>';
										} else {
											echo '<td headers="'.$key.'_'.$curYear.'">-</td>';
										}
									}
									?>
								</tr>
							</tbody>
						</table>
						<p>Erläuterungen zu dieser Kennzahl befinden sich in der <a href="<?php echo './guidance.php#'. $key; ?>">Anleitung</a>.</p>
					</section>
				<?php
					$counter++;
				}
				?>			
			</article>
		</main>
<?php
require './requires/footer.php';
?>

