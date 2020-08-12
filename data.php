<?php
    require './requires/header.php';
	echo '<script src="https://cdn.bokeh.org/bokeh/release/bokeh-2.1.1.min.js"></script>';
?>
		<aside>
		</aside>
		<main>
		<?php require './requires/mysql.php';
								
			//SQL-Abfragen vorbereiten und Array befüllen
			$getName = $conn->prepare("SELECT name,strasse,plz,ort,vorwahl,tel,url,öffnungszeiten,bestandsgrößenklasse,unterhaltsträger,dbv,leitung FROM bibs_data_table where dbsid= ?");
			$getName->execute(array($_GET['id']));

			$getChart = $conn->prepare("SELECT cjson FROM chart_data_table WHERE ctype='0' and dbsid= ?");
			$getChart->execute(array($_GET['id']));

			$getMedChart = $conn->query("SELECT cjson FROM chart_data_table WHERE ctype='0' and dbsid='MED'");
			$MedChart = $getMedChart->fetch();

			$getBoxPlot = $conn->prepare("SELECT cjson FROM chart_data_table WHERE ctype='1' and dbsid= ?");
			$getBoxPlot->execute(array($_GET['id']));

			$getCoreData = $conn->prepare("SELECT B131, B132, B224, B225, B333, B342, B422, B431 FROM core_data_table WHERE dbsid= ?");
			$getCoreData->execute(array($_GET['id'])); 

			$getMedData = $conn->query("SELECT B131, B132, B224, B225, B333, B342, B422, B431 FROM core_data_table WHERE dbsid='MED' AND cyear='2019'");
			$MedRow = $getMedData->fetch();
		?>
			<article>
				<header>
					<h2>Formale Daten</h2>
				</header>
				<?php
				
					//Tabelle für formale Daten
					if ($getName->rowCount() == 1) {
						$row = $getName->fetch(PDO::FETCH_ASSOC);
						$lib_name = $row["name"];
						echo '<div class="divTable" style="width: 100%;border: 1px solid #000;" >';
						echo '<div class="divTableBody">';
						echo '<div class="divTableRow">';
						echo '<div class="divTableCell">Kontakt</div>';
						echo '<div class="divTableCell">Öffnungszeiten</div>';
						echo '<div class="divTableCell">Weitere Informationen</div></div>';
						echo '<div class="divTableRow">';
						echo '<div class="divTableCell">'.$row["name"].'<br>'.$row["strasse"].'<br>'.$row["plz"].' '.$row["ort"].'<br>Tel: '.$row["vorwahl"].' '.$row["tel"].'<br>Web: <a href="'.$row["url"].'">'.$row["url"].'</a></div>';
						echo '<div class="divTableCell">'.$row["öffnungszeiten"].'</div>';
						echo '<div class="divTableCell">Bestandsgrößenklasse: '.$row["bestandsgrößenklasse"].'<br>Unterhaltsträger: '.$row["unterhaltsträger"]."<br>DBV: ".$row["dbv"]."<br>Leitung: ".$row["leitung"].'</div>';
						echo '</div></div></div>';
					}
					else {
						echo "<header><h2>Nichts gefunden!</h2></header>";
					}

					echo '</article>';
					
					//Artikel für das Netzdiagramm
					echo '<article>';
					echo '<header>';
					echo '<h2>Netzdiagramm</h2>';
					echo '</header>';
					if ($getChart->rowCount() > 0) {
						$row = $getChart->fetch(PDO::FETCH_ASSOC);
						echo '<script>item_r = JSON.parse(\''.$row["cjson"].'\');Bokeh.embed.embed_item(item_r);</script>';
						echo '<div id="inline" style="display:inline;width:100%;height:auto;display:flex;">';
						echo '<div id="'.strtoupper($_GET['id']).'_radar" class="mybokehplot bk-root" style="display:inline;"></div>';
						echo '<div class="divTable" style="position:relative;height:100%;display:inline;align-self:center;" >';
					}
					else {
						echo '<script>item_r = JSON.parse(\''.$MedChart["cjson"].'\');Bokeh.embed.embed_item(item_r);</script>';
						echo '<div id="inline" style="display:inline;width:100%;height:auto;display:flex;">';
						echo '<div id="MED_radar" class="mybokehplot bk-root" style="display:inline;"></div>';
						echo '<div class="divTable" style="position:relative;height:100%;display:inline;align-self:center;" >';
						echo '<div align="center" style="height:100px; width:100%;"><br><br>Für das laufende Berichtsjahr liegen keine Daten vor.</div>';
					}
					
					//Tabelle als Legende für die B-Nummern
					echo '<div class="divTableBody">';
					echo '<div class="divTableRow" style="font-weight:bold;">';
					echo '<div class="divTableCell">I</div>';
					echo '<div class="divTableCell">Ressourcen, Zugang und Infrastruktur</div></div>';
					echo '<div class="divTableRow">';
					echo '<div class="divTableCell">B.1.3.1</div>';
					echo '<div class="divTableCell">Verhältnis von Nutzungsfläche zu Primärnutzerschaft</div></div>';
					echo '<div class="divTableRow">';
					echo '<div class="divTableCell">B.1.3.2</div>';
					echo '<div class="divTableCell">Verhältnis von Arbeitsplätzen zu Primärnutzerschaft</div></div>';
					echo '<div class="divTableRow" style="font-weight:bold;">';
					echo '<div class="divTableCell">II</div>';
					echo '<div class="divTableCell">Nutzung</div></div>';
					echo '<div class="divTableRow">';
					echo '<div class="divTableCell">B.2.2.4</div>';
					echo '<div class="divTableCell">Verhältnis von Bibliotheksveranstaltungsbesuchen zu Primärnutzerschaft</div></div>';
					echo '<div class="divTableRow">';
					echo '<div class="divTableCell">B.2.2.5</div>';
					echo '<div class="divTableCell">Verhältnis von Schulungsbesuchen zu Primärnutzerschaft</div></div>';
					echo '<div class="divTableRow" style="font-weight:bold;">';
					echo '<div class="divTableCell">III</div>';
					echo '<div class="divTableCell">Effizienz</div></div>';
					echo '<div class="divTableRow">';
					echo '<div class="divTableCell">B.3.3.3</div>';
					echo '<div class="divTableCell">Verhältnis von Erwerbungs- zu Personalkosten</div></div>';
					echo '<div class="divTableRow">';
					echo '<div class="divTableCell">B.3.4.2</div>';
					echo '<div class="divTableCell">Kosten pro Bibliotheksbesuch</div></div>';
					echo '<div class="divTableRow" style="font-weight:bold;">';
					echo '<div class="divTableCell">IV</div>';
					echo '<div class="divTableCell">Potenziale und Entwicklung</div></div>';
					echo '<div class="divTableRow">';
					echo '<div class="divTableCell">B.4.2.2</div>';
					echo '<div class="divTableCell">Schulungsstunden pro Belegschaftsmitglied</div></div>';
					echo '<div class="divTableRow">';
					echo '<div class="divTableCell">B.4.3.1</div>';
					echo '<div class="divTableCell">Anteil von Sonderzuschüssen und selbst generierten Einnahmen am Gesamtbudget</div></div>';
					echo '</div></div></div>';

					//Datentabelle für das Netzdiagramm
					$row = $getCoreData->fetch(PDO::FETCH_ASSOC);
					echo '<div class="divTable" style="width: 100%; border: 1px solid #000;" >';
					echo '<div class="divTableBody">';
					echo '<div class="divTableRow" style="background-color: #F2F2F2">';
					echo '<div class="divTableCell"></div>';
					echo '<div class="divTableCell" style="border-right-width: 0;">I</div>';
					echo '<div class="divTableCell" style="border-left-width: 0;"></div>';
					echo '<div class="divTableCell" style="border-right-width: 0;">II</div>';
					echo '<div class="divTableCell" style="border-left-width: 0;"></div>';
					echo '<div class="divTableCell" style="border-right-width: 0;">III</div>';
					echo '<div class="divTableCell" style="border-left-width: 0;"></div>';
					echo '<div class="divTableCell" style="border-right-width: 0;">IV</div>';
					echo '<div class="divTableCell" style="border-left-width: 0;"></div>';
					echo '</div>';
					echo '<div class="divTableRow" style="background-color: #F2F2F2">';
					echo '<div class="divTableCell">Diagrammwerte</div>';
					echo '<div class="divTableCell">B.1.3.1</div>';
					echo '<div class="divTableCell">B.1.3.2</div>';
					echo '<div class="divTableCell">B.2.2.4</div>';
					echo '<div class="divTableCell">B.2.2.5</div>';
					echo '<div class="divTableCell">B.3.3.3</div>';
					echo '<div class="divTableCell">B.3.4.2</div>';
					echo '<div class="divTableCell">B.4.2.2</div>';
					echo '<div class="divTableCell">B.4.3.1</div></div>';
						
					echo '<div class="divTableRow">';
					echo '<div class="divTableCell" style="background-color: #F2F2F2">';
					if (isset($lib_name)) {echo $lib_name.'</div>';} else { echo '-</div>'; };
					echo '<div class="divTableCell">';
					if (isset($row["B131"])) { echo $row["B131"]; } else { echo '-'; };
					echo '</div><div class="divTableCell">';
					if (isset($row["B132"])) { echo $row["B132"]; } else { echo '-'; };
					echo '</div><div class="divTableCell">';
					if (isset($row["B224"])) { echo $row["B224"]; } else { echo '-'; };
					echo '</div><div class="divTableCell">';
					if (isset($row["B225"])) { echo $row["B225"]; } else { echo '-'; };
					echo '</div><div class="divTableCell">';
					if (isset($row["B333"])) { echo $row["B333"]; } else { echo '-'; };
					echo '</div><div class="divTableCell">';
					if (isset($row["B342"])) { echo $row["B342"]; } else { echo '-'; };
					echo '</div><div class="divTableCell">';
					if (isset($row["B422"])) { echo $row["B422"]; } else { echo '-'; };
					echo '</div><div class="divTableCell">';
					if (isset($row["B431"])) { echo $row["B431"]; } else { echo '-'; };
					echo '</div></div>';

					echo '<div class="divTableRow">';
					echo '<div class="divTableCell" style="background-color: #F2F2F2">Median</div>';
					echo '<div class="divTableCell">'.$MedRow["B131"].'</div>';
					echo '<div class="divTableCell">'.$MedRow["B132"].'</div>';
					echo '<div class="divTableCell">'.$MedRow["B224"].'</div>';
					echo '<div class="divTableCell">'.$MedRow["B225"].'</div>';
					echo '<div class="divTableCell">'.$MedRow["B333"].'</div>';
					echo '<div class="divTableCell">'.$MedRow["B342"].'</div>';
					echo '<div class="divTableCell">'.$MedRow["B422"].'</div>';
					echo '<div class="divTableCell">'.$MedRow["B431"].'</div>';
					echo '</div></div></div>';
					
					echo '</article>';
					
					//Article für die Kennzahlen-Zeitreihen
					echo '<article>';
					echo '<header>';
					echo '<h2>Kennzahlen-Zeitreihen</h2>';
					echo '</header>';

					if ($getBoxPlot->rowCount() > 0) {
						$row = $getBoxPlot->fetch(PDO::FETCH_ASSOC);
						echo '<br><script>item_b = JSON.parse(\''.$row["cjson"].'\');Bokeh.embed.embed_item(item_b);</script>';
						echo '<div id="'.strtoupper($_GET['id']).'_boxplot" class="mybokehplot bk-root" style="display:flex; justify-content: center; align-items:center;"></div>';
					}
					?>
			</article>
		</main>
<?php
	require './requires/footer.php';
?>
