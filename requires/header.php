<!DOCTYPE html>
<html lang="de">
<?php
	$pages = [
		['name' => 'search',	'linktext' => 'Suche',				'place' => 'header' ],
		['name' => 'stop',		'linktext' => 'Anleitung',			'place' => 'header' ],
		['name' => 'stop',		'linktext' => 'Hintergrund',		'place' => 'header' ],
		['name' => 'stop',		'linktext' => 'Blog',				'place' => 'header' ],
		['name' => 'stop',		'linktext' => 'Konto',				'place' => 'header'],
		['name' => 'stop',		'linktext' => 'Kontaktformular',	'place' => 'footer'],
		['name' => 'impressum',	'linktext' => 'Impressum',			'place' => 'footer'],
		['name' => 'data',		'linktext' => 'Daten',				'place' => 'nowhere'],
	];

	$title = "Startseite - DBS-VIS";
	foreach ($pages as $index => $page) :
		$listitem = "<li";
		if ($_SERVER["SCRIPT_NAME"] == "/dbs-vis/" . $page["name"] . ".php") :
			$listitem .= " aria-current='page'><a>";
			$title = $page["linktext"] . " - DBS-VIS";
		else :
			$listitem .= "><a href='" . $page["name"] . ".php'>";
		endif;
		$listitem .= $page["linktext"] . "</a></li>";
		$pages[$index]["listitem"] = $listitem;	
	endforeach;
?>
	<head>
		<title><?php echo $title; ?></title>
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
					<h1>DBS-VIS</h1>
				</a>
			</div>
		</header>
		<nav>
			<ul>
				<?php
					foreach ($pages as $page) :
						if ($page["place"] == "header"):
							echo $page["listitem"];
						endif;
					endforeach;
				?>
			</ul>
		</nav>
		<div id="pageactions">