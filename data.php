<?php
        include ("./includes/header.php");
?>

</div>

<main>

	<article>
<!--
		<script type = "text/javascript">
			const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);
			const library_id = urlParams.get('id')
			console.log(library_id);
		</script> 
-->

		<?php session_start(); require('mysql.php');

		$getName = $conn->prepare("SELECT name, strasse, plz, ort, vorwahl, tel, url, öffnungszeiten, bestandsgrößenklasse, unterhaltsträger, dbv, leitung FROM bibs_data_table where dbsid= ?");
		$getName->execute(array($_GET['id']));
		if ($getName->rowCount() == 1) {
			$row = $getName->fetch(PDO::FETCH_ASSOC);

			echo '<div class="divTable" style="width: 100%;border: 1px solid #000;" >';
			echo '<div class="divTableBody">';
			
			echo '<div class="divTableRow">';
			echo '<div class="divTableCell">Anschrift:</div>';
			echo '<div class="divTableCell">Öffnungszeiten:</div>';
			echo '<div class="divTableCell">Weitere Informationen:</div>';
			echo '</div>';

			echo '<div class="divTableRow">';
			echo '<div class="divTableCell">'.$row["name"].'<br>'.$row["strasse"].'<br>'.$row["plz"].' '.$row["ort"].'<br>Tel: '.$row["vorwahl"].' '.$row["tel"].'<br>Web: '.$row["url"].'</div>';
			echo '<div class="divTableCell">'.$row["öffnungszeiten"].'</div>';
			echo '<div class="divTableCell">Bestandsgrößenklasse: '.$row["bestandsgrößenklasse"].'<br>Unterhaltsträger: '.$row["unterhaltsträger"]."<br>DBV: ".$row["dbv"]."<br>Leitung: ".$row["leitung"].'</div>';
			echo '</div>';

			echo '</div>';
			echo '</div>';
			
		} else {
			echo "<header><h2>Nichts gefunden!</h2></header>";
		}
		
		$getChart = $conn->prepare("SELECT cjson FROM chart_data_table WHERE dbsid= ?");
		$getChart->execute(array($_GET['id']));
		
		if ($getChart->rowCount() == 1) {
			$row = $getChart->fetch(PDO::FETCH_ASSOC);
			echo '<script type="text/javascript" src="https://cdn.bokeh.org/bokeh/release/bokeh-2.1.1.min.js"></script>';
			echo '<script>item = JSON.parse(\''.$row["cjson"].'\');Bokeh.embed.embed_item(item);</script>';
			echo '<div id="'.$_GET['id'].'" class="mybokehplot bk-root"></div>';
		}

		$getCoreData = $conn->prepare("SELECT B124, B131, B132, B141, B221, B224, B225, B333, B341, B342, B422, B431 FROM core_data_table WHERE dbsid= ?");
		$getCoreData->execute(array($_GET['id'])); 

		if ($getCoreData->rowCount() == 1) {
	
			$row = $getCoreData->fetch(PDO::FETCH_ASSOC);

			echo '<div class="divTable" style="width: 100%;border: 1px solid #000;" >';
			echo '<div class="divTableBody">';

			echo '<div class="divTableRow">';
			echo '<div class="divTableCell">Diagramm:</div>';
			echo '<div class="divTableCell">B.1.2.4:</div>';
			echo '<div class="divTableCell">B.1.3.1:</div>';
			echo '<div class="divTableCell">B.1.3.2:</div>';
			echo '<div class="divTableCell">B.1.4.1:</div>';
			echo '<div class="divTableCell">B.2.2.1:</div>';
			echo '<div class="divTableCell">B.2.2.4:</div>';
			echo '<div class="divTableCell">B.2.2.5:</div>';
			echo '<div class="divTableCell">B.3.3.3:</div>';
			echo '<div class="divTableCell">B.3.4.1:</div>';
			echo '<div class="divTableCell">B.3.4.2:</div>';
			echo '<div class="divTableCell">B.4.2.2:</div>';
			echo '<div class="divTableCell">B.4.3.1:</div>';
			echo '</div>';
			
			$getMaxData = $conn->query("SELECT B124, B131, B132, B141, B221, B224, B225, B333, B341, B342, B422, B431 FROM core_data_table WHERE dbsid='MAX' AND cyear='2019'");
			$MaxRow = $getMaxData->fetch();

			echo '<div class="divTableRow">';
			echo '<div class="divTableCell">Current:</div>';
			echo '<div class="divTableCell">';
			if ($row["B124"]) echo round($row["B124"]*100/$MaxRow["B124"], 2).'%';
			echo '</div><div class="divTableCell">';
			if ($row["B131"]) echo round($row["B131"]*100/$MaxRow["B131"], 2).'%';
			echo '</div><div class="divTableCell">';
			if ($row["B132"]) echo round($row["B132"]*100/$MaxRow["B132"], 2).'%';
			echo '</div><div class="divTableCell">';
			if ($row["B141"]) echo round($row["B141"]*100/$MaxRow["B141"], 2).'%';
			echo '</div><div class="divTableCell">';
			if ($row["B221"]) echo round($row["B221"]*100/$MaxRow["B221"], 2).'%';
			echo '</div><div class="divTableCell">';
			if ($row["B224"]) echo round($row["B224"]*100/$MaxRow["B224"], 2).'%';
			echo '</div><div class="divTableCell">';
			if ($row["B225"]) echo round($row["B225"]*100/$MaxRow["B225"], 2).'%';
			echo '</div><div class="divTableCell">';
			if ($row["B333"]) echo round($row["B333"]*100/$MaxRow["B333"], 2).'%';
			echo '</div><div class="divTableCell">';
			if ($row["B341"]) echo round($row["B341"]*100/$MaxRow["B341"], 2).'%';
			echo '</div><div class="divTableCell">';
			if ($row["B342"]) echo round($row["B342"]*100/$MaxRow["B342"], 2).'%';
			echo '</div><div class="divTableCell">';
			if ($row["B422"]) echo round($row["B422"]*100/$MaxRow["B422"], 2).'%';
			echo '</div><div class="divTableCell">';
			if ($row["B431"]) echo round($row["B431"]*100/$MaxRow["B431"], 2).'%';
			echo '</div></div>';

			$getMedData = $conn->query("SELECT B124, B131, B132, B141, B221, B224, B225, B333, B341, B342, B422, B431 FROM core_data_table WHERE dbsid='MED' AND cyear='2019'");
			$MedRow = $getMedData->fetch();
			
			echo '<div class="divTableRow">';
			echo '<div class="divTableCell">Median:</div>';
			echo '<div class="divTableCell">'.round($MedRow["B124"]*100/$MaxRow["B124"], 2).'%'.'</div>';
			echo '<div class="divTableCell">'.round($MedRow["B131"]*100/$MaxRow["B131"], 2).'%'.'</div>';
			echo '<div class="divTableCell">'.round($MedRow["B132"]*100/$MaxRow["B132"], 2).'%'.'</div>';
			echo '<div class="divTableCell">'.round($MedRow["B141"]*100/$MaxRow["B141"], 2).'%'.'</div>';
			echo '<div class="divTableCell">'.round($MedRow["B221"]*100/$MaxRow["B221"], 2).'%'.'</div>';
			echo '<div class="divTableCell">'.round($MedRow["B224"]*100/$MaxRow["B224"], 2).'%'.'</div>';
			echo '<div class="divTableCell">'.round($MedRow["B225"]*100/$MaxRow["B225"], 2).'%'.'</div>';
			echo '<div class="divTableCell">'.round($MedRow["B333"]*100/$MaxRow["B333"], 2).'%'.'</div>';
			echo '<div class="divTableCell">'.round($MedRow["B341"]*100/$MaxRow["B341"], 2).'%'.'</div>';
			echo '<div class="divTableCell">'.round($MedRow["B342"]*100/$MaxRow["B342"], 2).'%'.'</div>';
			echo '<div class="divTableCell">'.round($MedRow["B422"]*100/$MaxRow["B422"], 2).'%'.'</div>';
			echo '<div class="divTableCell">'.round($MedRow["B431"]*100/$MaxRow["B431"], 2).'%'.'</div>';
			echo '</div>';

			echo '</div>';
			echo '</div>';
		}
		
		?>

<?php
        include ("./includes/footer.php");
?>
