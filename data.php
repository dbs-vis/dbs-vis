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
		if ($getName->rowCount() > 0) {

			echo '<div class="divTable" style="width: 100%;border: 1px solid #000;" >';
			echo '<div class="divTableBody">';
			
			echo '<div class="divTableRow">';
			echo '<div class="divTableCell">Anschrift:</div>';
			echo '<div class="divTableCell">Öffnungszeiten</div>';
			echo '<div class="divTableCell">Weitere Informationen</div>';
			echo '</div>';

			foreach ($getName as $row) {
				echo '<div class="divTableRow">';
				echo '<div class="divTableCell">'.$row["name"].'<br>'.$row["strasse"].'<br>'.$row["plz"].' '.$row["ort"].'<br>Tel: '.$row["vorwahl"].' '.$row["tel"].'<br>Web: '.$row["url"].'</div>';
				echo '<div class="divTableCell">'.$row["öffnungszeiten"].'</div>';
				echo '<div class="divTableCell">Bestandsgrößenklasse: '.$row["bestandsgrößenklasse"].'<br>Unterhaltsträger: '.$row["unterhaltsträger"]."<br>DBV: ".$row["dbv"]."<br>Leitung: ".$row["leitung"].'</div>';
				echo '</div>';
			}

			echo '</div>';
			echo '</div>';
		} else {
			echo "<header><h2>Nichts gefunden!</h2></header>";
		}
		?>

<?php
        include ("./includes/footer.php");
?>
