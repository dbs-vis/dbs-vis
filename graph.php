<?php
        include ("./includes/header.php");
?>

</div>

<main>
	<article>
		<header>
			<h2>Let's draw something!</h2>
		</header>

<!--
		<script type = "text/javascript">
			const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);
			const library_id = urlParams.get('id')
			console.log(library_id);
		</script> 
-->

		<?php session_start(); require('mysql.php');

		$getName = $conn->prepare("SELECT name FROM bibs_data_table where dbsid= ?");
		$getName->execute(array($_GET['id']));
		if ($getName->rowCount() > 0)
			foreach ($getName as $row) {
				echo "For example, diagrams for ".$row["name"];
			}
		else
			echo "Nah, don't want";

		?>

<?php
        include ("./includes/footer.php");
?>
