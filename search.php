<?php
	include ("./includes/header.php");
?>
			Hier befindet sich das Steuerungsfeld.
		</div>
		<main>
			<article>
				<header>
					<h2>Karte</h2>
				</header>
				<figure id="map">
					<p>Diese Seite lädt das Leaflet-Script von <a href="https://unpkg.com" target="_blank">unpkg.com</a> sowie das Kartenmaterial von <a href="https://www.openstreetmap.org/">OpenStreetMap</a>.</p>
					<p>Ist das <button type="button" id="okButton">OK</button>?</p>
				</figure>
				<script>
					"use strict";
					if(localStorage && localStorage.getItem("leafletOK")) {
						erstelleKarte();
					}
					else {
						document.querySelector("#okButton").addEventListener("click", erstelleKarte);
					}
					
					function erstelleKarte() {
						// CSS laden
						loadCSS("https://unpkg.com/leaflet@1.4.0/dist/leaflet.css");
						// Leafletscript laden
						loadScript("https://unpkg.com/leaflet@1.4.0/dist/leaflet.js", kartenScript);
					}
				
					function kartenScript() {
						var mapcanvas = document.querySelector("#map");
						mapcanvas.innerHTML = "";
						
						// Karten anlegen
						var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
							maxZoom: 19,
							attribution: 'Map data &copy;<a href="https://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> and contributors <a href="https://creativecommons.org/licenses/by-sa/2.0/" target="_blank">CC-BY-SA</a>'
						});
						
						var map = L.map(mapcanvas, { layers: osm, tap: false } ) ;
						
						// Mit Maßstab
						L.control.scale({imperial:false}).addTo(map);
						
						//Kartenausschnitt wählen
						var bounds = [ [55.4, 5.7], [46.4, 17.2] ];
						map.fitBounds( bounds );
						
						// Karte bei resize neu skalieren
						map.on("resize", function(e){
							map.fitBounds( bounds );
						});

						<?php
							error_reporting(E_ALL);
							ini_set('display_errors', 1);
							
							$servername = "localhost";
							$username = "root";
							$password = "";
							$database = "dbs_vis_db";

							// Create connection
							$conn = mysqli_connect($servername, $username, $password, $database);

							// Check connection
							if (!$conn) {
								die("Connection failed: " . mysqli_connect_error());
							}

							// Create Query
							$sql = "SELECT name, ST_X(pt) AS laenge, ST_Y(pt) AS breite FROM bibs_data_table;";
							$result = mysqli_query($conn, $sql);
							$row = mysqli_fetch_assoc($result);
							while ($row = mysqli_fetch_assoc($result)) {
								echo "L.marker([", $row["breite"], ", ", $row['laenge'], "]).addTo(map).bindPopup('", $row["name"], "');";
							}

							/* free result set */
							mysqli_free_result($result);

							/* close connection */
							mysqli_close($conn);
						?>
					}

					function loadScript(url,callback) {
						var scr = document.createElement('script');
						scr.type = "text/javascript";
						scr.async = "async";
						if(typeof(callback)=="function") {
							scr.onloadDone = false;
							scr.onload = function() { 
								if ( !scr.onloadDone ) {
									scr.onloadDone = true;
									callback(); 
								}
							};
							scr.onreadystatechange = function() { 
								if ( ( "loaded" === scr.readyState || "complete" === scr.readyState ) && !scr.onloadDone ) {
									scr.onloadDone = true; 
									callback();
								}
							}
						}
						scr.src = url;
						document.getElementsByTagName('head')[0].appendChild(scr);
					} // LoadScript

					function loadCSS(url) {
						var l = document.createElement("link");
						l.type = "text/css";
						l.rel = "stylesheet";
						l.href = url;
						document.getElementsByTagName("head")[0].appendChild(l);
					} // LoadCSS

				</script>
			</article>
			<article id="bib_list">
				<header>
					<h2>Liste</h2>
				</header>
				Hier soll zukünftig eine Liste aller auf der Karte angezeigten Bibliotheken zu sehen sein.
			</article>
<?php
	include ("./includes/footer.php");
?>	