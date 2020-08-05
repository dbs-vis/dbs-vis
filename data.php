<?php
        include ("./includes/header.php");
	echo '<script type="text/javascript" src="https://cdn.bokeh.org/bokeh/release/bokeh-2.1.1.min.js"></script>';
?>

</div>
<main>
<article>
	<?php require 'mysql.php';
	$getName = $conn->prepare("SELECT name,strasse,plz,ort,vorwahl,tel,url,öffnungszeiten,bestandsgrößenklasse,unterhaltsträger,dbv,leitung FROM bibs_data_table where dbsid= ?");
	$getName->execute(array($_GET['id']));
	
	$getChart = $conn->prepare("SELECT cjson FROM chart_data_table WHERE ctype='0' and dbsid= ?");
	$getChart->execute(array($_GET['id']));

	$getBoxPlot = $conn->prepare("SELECT cjson FROM chart_data_table WHERE ctype='1' and dbsid= ?");
	$getBoxPlot->execute(array($_GET['id']));
	
	$getCoreData = $conn->prepare("SELECT B124, B131, B132, B141, B221, B224, B225, B333, B341, B342, B422, B431 FROM core_data_table WHERE dbsid= ?");
	$getCoreData->execute(array($_GET['id'])); 
	
	$getMedData = $conn->query("SELECT B124, B131, B132, B141, B221, B224, B225, B333, B341, B342, B422, B431 FROM core_data_table WHERE dbsid='MED' AND cyear='2019'");
	$MedRow = $getMedData->fetch();
	
	if ($getName->rowCount() == 1) {
		$row = $getName->fetch(PDO::FETCH_ASSOC);
		$lib_name = $row["name"];
		echo '<div class="divTable" style="width: 100%;border: 1px solid #000;" >';
		echo '<div class="divTableBody">';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">Anschrift:</div>';
		echo '<div class="divTableCell">Öffnungszeiten:</div>';
		echo '<div class="divTableCell">Weitere Informationen:</div></div>';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">'.$row["name"].'<br>'.$row["strasse"].'<br>'.$row["plz"].' '.$row["ort"].'<br>Tel: '.$row["vorwahl"].' '.$row["tel"].'<br>Web: '.$row["url"].'</div>';
		echo '<div class="divTableCell">'.$row["öffnungszeiten"].'</div>';
		echo '<div class="divTableCell">Bestandsgrößenklasse: '.$row["bestandsgrößenklasse"].'<br>Unterhaltsträger: '.$row["unterhaltsträger"]."<br>DBV: ".$row["dbv"]."<br>Leitung: ".$row["leitung"].'</div>';
		echo '</div></div></div>';
	} else {
		echo "<header><h2>Nichts gefunden!</h2></header>";
	}

	echo '</article>';
	echo '<article>';
	
	if ($getChart->rowCount() > 0) {
		$row = $getChart->fetch(PDO::FETCH_ASSOC);
		echo '<script>item_r = JSON.parse(\''.$row["cjson"].'\');Bokeh.embed.embed_item(item_r);</script>';
		echo '<div id="inline" style="display:inline;width:100%;height:auto;display:flex;">';
		echo '<div id="'.strtoupper($_GET['id']).'_radar" align="center" class="mybokehplot bk-root" style="display:inline;"></div>';
			
		echo '<div class="divTable" align="center" style="position:relative;height:100%;display:inline;align-self:center;" >';
		echo '<div class="divTableBody">';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">B.1.2.4</div>';
		echo '<div class="divTableCell">Erfolgreiche Fernleihen</div></div>';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">B.1.3.1</div>';
		echo '<div class="divTableCell">Verhältnis von Nutzungsfläche zu Primärnutzerschaft</div></div>';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">B.1.3.2</div>';
		echo '<div class="divTableCell">Verhältnis von Arbeitsplätzen zu Primärnutzerschaft</div></div>';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">B.1.4.1</div>';
		echo '<div class="divTableCell">Verhältnis von Belegschaft zu Primärnutzerschaft</div></div>';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">B.2.2.1</div>';
		echo '<div class="divTableCell">Verhältnis von Bibliotheksbesuchen zu Primärnutzerschaft</div></div>';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">B.2.2.4</div>';
		echo '<div class="divTableCell">Verhältnis von Bibliotheksveranstaltungsbesuchen zu Primärnutzerschaft</div></div>';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">B.2.2.5</div>';
		echo '<div class="divTableCell">Verhältnis von Schulungsbesuchen zu Primärnutzerschaft</div></div>';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">B.3.3.3</div>';
		echo '<div class="divTableCell">Verhältnis von Erwerbungs- zu Personalkosten</div></div>';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">B.3.4.1</div>';
		echo '<div class="divTableCell">Kosten pro aktive Nutzende</div></div>';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">B.3.4.2</div>';
		echo '<div class="divTableCell">Kosten pro Bibliotheksbesuch</div></div>';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">B.4.2.2</div>';
		echo '<div class="divTableCell">Schulungsstunden pro Belegschaftsmitglied</div></div>';
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell">B.4.3.1</div>';
		echo '<div class="divTableCell">Anteil von Sonderzuschüssen und selbst generierten Einnahmen am Gesamtbudget</div></div>';
		echo '</div></div></div>';
	} else {
		echo '<div align="center" style="height:100px; width:100%;"><br><br>Für das laufende Berichtsjahr liegen keine Daten vor.</div>';
	}

		$row = $getCoreData->fetch(PDO::FETCH_ASSOC);
		echo '<div class="divTable" style="width: 100%; border: 1px solid #000;" >';
		echo '<div class="divTableBody">';
		echo '<div class="divTableRow" style="background-color: #F2F2F2">';
		echo '<div class="divTableCell">Diagrammwerte</div>';
		echo '<div class="divTableCell">B.1.2.4</div>';
		echo '<div class="divTableCell">B.1.3.1</div>';
		echo '<div class="divTableCell">B.1.3.2</div>';
		echo '<div class="divTableCell">B.1.4.1</div>';
		echo '<div class="divTableCell">B.2.2.1</div>';
		echo '<div class="divTableCell">B.2.2.4</div>';
		echo '<div class="divTableCell">B.2.2.5</div>';
		echo '<div class="divTableCell">B.3.3.3</div>';
		echo '<div class="divTableCell">B.3.4.1</div>';
		echo '<div class="divTableCell">B.3.4.2</div>';
		echo '<div class="divTableCell">B.4.2.2</div>';
		echo '<div class="divTableCell">B.4.3.1</div></div>';
			
		echo '<div class="divTableRow">';
		echo '<div class="divTableCell" style="background-color: #F2F2F2">'.$lib_name.':</div>';
		echo '<div class="divTableCell">';
		if (isset($row["B124"])) { echo $row["B124"]; } else { echo '-'; };
		echo '</div><div class="divTableCell">';
		if (isset($row["B131"])) { echo $row["B131"]; } else { echo '-'; };
		echo '</div><div class="divTableCell">';
		if (isset($row["B132"])) { echo $row["B132"]; } else { echo '-'; };
		echo '</div><div class="divTableCell">';
		if (isset($row["B141"])) { echo $row["B141"]; } else { echo '-'; };
		echo '</div><div class="divTableCell">';
		if (isset($row["B221"])) { echo $row["B221"]; } else { echo '-'; };
		echo '</div><div class="divTableCell">';
		if (isset($row["B224"])) { echo $row["B224"]; } else { echo '-'; };
		echo '</div><div class="divTableCell">';
		if (isset($row["B225"])) { echo $row["B225"]; } else { echo '-'; };
		echo '</div><div class="divTableCell">';
		if (isset($row["B333"])) { echo $row["B333"]; } else { echo '-'; };
		echo '</div><div class="divTableCell">';
		if (isset($row["B341"])) { echo $row["B341"]; } else { echo '-'; };
		echo '</div><div class="divTableCell">';
		if (isset($row["B342"])) { echo $row["B342"]; } else { echo '-'; };
		echo '</div><div class="divTableCell">';
		if (isset($row["B422"])) { echo $row["B422"]; } else { echo '-'; };
		echo '</div><div class="divTableCell">';
		if (isset($row["B431"])) { echo $row["B431"]; } else { echo '-'; };
		echo '</div></div>';

		echo '<div class="divTableRow">';
		echo '<div class="divTableCell" style="background-color: #F2F2F2">Median:</div>';
		echo '<div class="divTableCell">'.$MedRow["B124"].'</div>';
		echo '<div class="divTableCell">'.$MedRow["B131"].'</div>';
		echo '<div class="divTableCell">'.$MedRow["B132"].'</div>';
		echo '<div class="divTableCell">'.$MedRow["B141"].'</div>';
		echo '<div class="divTableCell">'.$MedRow["B221"].'</div>';
		echo '<div class="divTableCell">'.$MedRow["B224"].'</div>';
		echo '<div class="divTableCell">'.$MedRow["B225"].'</div>';
		echo '<div class="divTableCell">'.$MedRow["B333"].'</div>';
		echo '<div class="divTableCell">'.$MedRow["B341"].'</div>';
		echo '<div class="divTableCell">'.$MedRow["B342"].'</div>';
		echo '<div class="divTableCell">'.$MedRow["B422"].'</div>';
		echo '<div class="divTableCell">'.$MedRow["B431"].'</div>';
		echo '</div></div></div>';
	
	echo '</article>';
	echo '<article>';

	if ($getBoxPlot->rowCount() > 0) {
		$row = $getBoxPlot->fetch(PDO::FETCH_ASSOC);
		echo '<br><script>item_b = JSON.parse(\''.$row["cjson"].'\');Bokeh.embed.embed_item(item_b);</script>';
		echo '<div id="'.strtoupper($_GET['id']).'_boxplot" class="mybokehplot bk-root" align="center" style="display:inline;"></div>';
	}
	?>
</article>

<?php
        include ("./includes/footer.php");
?>
