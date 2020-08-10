<?php
	require './requires/header.php';
?>
		</div>
		<main>
			<article>
				<header>
					<h2 id="data">Daten</h2>
				</header>
				<p>Die Datenseite bietet in den drei Abschnitten <em>Formale Daten</em>, <em>Netzdiagramm</em> und <em>Kennzahlen-Zeitreihen</em> unterschiedliche Informationen über die ausgewählte Bibliothek.</p>
				<p>Der Abschnitt <em>Formale Daten</em> bietet in einer Tabelle Informationen aus der <a href="https://www.bibliotheksstatistik.de/bibsFilter?ini=start">Bibliothekssuchmaschine</a> z. B. zur Anschrift und zu Öffnungszeiten an.</p>
				<p>
					Die Kennzahlen des Netzdiagramms und der Kennzahlen-Zeitreihen wurden nach der Norm <a href="https://www.iso.org/standard/56755.html">ISO 11620:2014</a> berechnet. Für die Visualisierungen wurde auf das Framework <a href="https://bokeh.org/">Bokeh</a> zurückgegriffen. Es bietet an den Visualisierungen verschiedene Schaltflächen an:
					<ul>
						<li class="guidanceList"><em>Link zu Bokeh</em>: Über diese Schaltfläche gelangt man zur Startseite von Bokeh.</li>
						<li class="guidanceList"><em>Pan</em>: Ist diese Schaltfläche aktiviert, kann man das Diagramm bei gedrückter linker Maustaste in seinem Rahmen verschieben.</li>
						<li class="guidanceList"><em>Box Zoom</em>: Ist diese Schaltfläche aktiviert, kann man mit gedrückter linker Maustaste einen Rahmen in der Grafik ziehen, welcher nach dem Loslassen der Maustaste der neuen Bildausschnitt wird.</li>
						<li class="guidanceList"><em>Wheel Zoom</em>: Ist diese Schaltfläche aktiviert, kann man durch Drehen des Mausrades an die Stelle, an der sich der Mauszeiger befindet, heranzoomen.</li>
						<li class="guidanceList"><em>Save</em>: Klickt man auf diese Schaltfläche, wird der aktuelle Bildausschnitt des Diagramms heruntergeladen.</li>
						<li class="guidanceList"><em>Reset</em>: Klickt man auf diese Schaltfläche, wird der Originalzustand der Grafik wiederhergestellt.</li>
						<li class="guidanceList"><em>Link zur Hilfe</em>: Über diese Schaltfläche gelangt man zur Hilfeseite von Bokeh.</li>
					</ul>
				</p>
				<p>Das <em>Netzdiagramm</em> stellt unterschiedliche Kennzahlen dar, indem ein regelmäßiges n-Eck gebildet wird, dass für jede Kennzahl eine Achse aufweist. Die für die Erstellung des Diagramms benötigten Daten entstammen nur dem aktuellen DBS-Berichtsjahr. Die acht im Netzdiagramm dargestellten Leistungsindikatoren sind nach dem Balanced Scorecard-Ansatz der ISO 11620:2014 angeordnet. Die Achsen des Diagramms reichen dabei für jede Kennzahl von 0 bis zu derem größten Wert. Zur Kontextualisierung der Bibliotheksdaten wird als Vergleich für jede Kennzahl auch der Median eingezeichnet. Die Benennung der einzelnen Bereiche und Kennzahlen sowie ihre numerischen Werte werden in zwei separaten Tabellen dargestellt.</p>
				<p>
					Die <em>Kennzahlen-Zeitreihen</em> stellen alle Kennzahlen dar, die mit den statistischen Werten der DBS nach den Regeln der Norm ISO 11620:2014 gebildet werden können. Die Werte der betrachteten Bibliothek sind in orange eingetragen. Zur Kontextualisierung wird für jedes Jahr ein Boxplot aus allen Werten dieser Kennzahl berechnet. Der Boxplot setzt sich aus verschiedenen Bestandteilen zusammen:
					<ul>
						<li class="guidanceList"><em>Ausreißer nach oben</em>: Graue Punkte repräsentieren alle Werte, die größer sind als Drittes Quartil + 1,5 Interquartilsabstände (Interquartilsabstand = Drittes Quartil - Erstes Quartil).</li>
						<li class="guidanceList"><em>Oberes Schnurrhaar</em>: Der senkrechte Strich mit dem waagerechten Ende beginnt beim Dritten Quartil und erstreckt sich bis zum größten Wert, der maximal 1,5 Interquartilsabstände vom Dritten Quartil entfernt ist.</li>
						<li class="guidanceList"><em>Drittes Quartil</em>: Der mittlere waagerechte Strich der Box teilt die Menge der Werte so, dass 75% der Werte kleiner und 25% größer als er sind.</li>
						<li class="guidanceList"><em>Zweites Quartil (Median)</em>: Der mittlere waagerechte Strich der Box teilt die Menge der Werte so, dass 50% der Werte kleiner und 50% größer als er sind.</li>
						<li class="guidanceList"><em>Erstes Quartil</em>: Der untere waagerechte Strich der Box teilt die Menge der Werte so, dass 25% der Werte kleiner und 75% größer als er sind.</li>
						<li class="guidanceList"><em>Unteres Schnurrhaar</em>: Der senkrechte Strich mit dem waagerechten Ende beginnt beim Ersten Quartil und erstreckt sich bis zum kleinsten Wert, der maximal 1,5 Interquartilsabstände vom Ersten Quartil entfernt ist.</li>
						<li class="guidanceList"><em>Ausreißer nach unten</em>: Graue Punkte repräsentieren alle Werte, die kleiner sind als Erstes Quartil - 1,5 Interquartilsabstände (Interquartilsabstand = Drittes Quartil - Erstes Quartil).</li>
					</ul>
				</p>			
			</article>
			<article>
				<header>
					<h2 id="search">Suche</h2>
				</header>
				<p>Die Suche ermöglicht den Zugang zu den Daten der einzelnen Bibliotheken der DBS-Jahrgänge 2018 und 2019. Sie besteht aus zwei getrennten Bereichen: der <em><a href="./search.php#map">Karte</a></em> und der <em><a href="./search.php#list">Liste</a></em>.</p>
				<p>Die <em>Karte</em> bietet für alle Bibliotheken einen Marker an. Klickt man auf einen Marker, öffnet sich ein Textfenster und der Name der Bibliothek, wie er in der DBS verwendet wird, erscheint. Dieser Name ist ein Link zur individuellen Datenseite für die Bibliothek.</p>
				<p>Die <em>Liste</em> ist ein aufklappbares Formular und enthält alle Bibliotheksnamen. Zum Aufrufen der individuellen Datenseite für die Bibliothek, muss zuerst auf den Namen der Bibliothek in der aufgeklappten Liste und danach auf den Button "Finden" geklickt werden.</p>
			</article>
<?php
	require './requires/footer.php';
?>		
