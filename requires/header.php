<!DOCTYPE html>
<html lang="de">
	<head>
		<title>Startseite - dbs-vis</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="./stylesheet.css">
		<link rel="icon" type="image/svg+xml" href="./graphics/favicon.svg" sizes="any">
	</head>
	<body>
		<header>
			<div id="headline">
				<a href="./index.php" class="head">
					<img id="logo" alt="" src="graphics/logo.svg">
					<h1>DBS-Vis</h1>
				</a>
			</div>
		</header>
		<?php
			$pages = [
				[
					'name' => 'search',
					'linktext' => 'Suche',
				],
				[
					'name' => 'stop',
					'linktext' => 'Anleitung',
				],
				[
					'name' => 'stop',
					'linktext' => 'Hintergrund',
				],
				[
					'name' => 'stop',
					'linktext' => 'Blog',
				],
				[
					'name' => 'stop',
					'linktext' => 'Konto',
				],
			];

			foreach ($pages as $index => $page) :
			  $listitem = "<li";
			  if ($_SERVER["SCRIPT_NAME"] == "/dbs-vis/" . $page["name"] . ".php") :
				$listitem .= " aria-current='page'><a>";
			  else :
				$listitem .= "><a href='" . $page["name"] . ".php'>";
			  endif;
			  $listitem .= $page["linktext"] . "</a></li>";
			  $pages[$index]["listitem"] = $listitem;
			endforeach;
		?>
		<nav>
			<ul>
				<?php
					foreach ($pages as $page) : echo $page["listitem"];
					endforeach;
				?>
			</ul>
		</nav>
		<div id="pageactions">