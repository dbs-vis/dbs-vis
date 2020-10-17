<?php
	require './requires/header.php';
?>
		<aside>
		</aside>
		<main>
			<article id="data">
				<header>
					<h2>Daten</h2>
				</header>
				<p>Die Datenseite bietet in den drei Abschnitten <em>Formale Daten</em>, <em>Netzdiagramm</em> und <em>Kennzahlen-Zeitreihen</em> unterschiedliche Informationen über die ausgewählte Bibliothek.</p>
				<p>Der Abschnitt <em>Formale Daten</em> bietet in einer Tabelle Informationen aus der <a href="https://www.bibliotheksstatistik.de/bibsFilter?ini=start">Bibliothekssuchmaschine</a> z. B. zur Anschrift und zu Öffnungszeiten an.</p>
				<p>Die Kennzahlen des Netzdiagramms und der Kennzahlen-Zeitreihen wurden nach der Norm <a href="https://www.iso.org/standard/56755.html">ISO 11620:2014</a> berechnet. Für die Visualisierungen wurde auf das Framework <a href="https://bokeh.org/">Bokeh</a> zurückgegriffen. Es bietet an den Visualisierungen verschiedene Schaltflächen an:</p>
				<ul>
					<li class="guidanceList"><em>Link zu Bokeh</em>: Über diese Schaltfläche gelangt man zur Startseite von Bokeh.</li>
					<li class="guidanceList"><em>Pan</em>: Ist diese Schaltfläche aktiviert, kann man das Diagramm bei gedrückter linker Maustaste in seinem Rahmen verschieben.</li>
					<li class="guidanceList"><em>Box Zoom</em>: Ist diese Schaltfläche aktiviert, kann man mit gedrückter linker Maustaste einen Rahmen in der Grafik ziehen, welcher nach dem Loslassen der Maustaste der neuen Bildausschnitt wird.</li>
					<li class="guidanceList"><em>Wheel Zoom</em>: Ist diese Schaltfläche aktiviert, kann man durch Drehen des Mausrades an die Stelle, an der sich der Mauszeiger befindet, heranzoomen.</li>
					<li class="guidanceList"><em>Save</em>: Klickt man auf diese Schaltfläche, wird der aktuelle Bildausschnitt des Diagramms heruntergeladen.</li>
					<li class="guidanceList"><em>Reset</em>: Klickt man auf diese Schaltfläche, wird der Originalzustand der Grafik wiederhergestellt.</li>
					<li class="guidanceList"><em>Link zur Hilfe</em>: Über diese Schaltfläche gelangt man zur Hilfeseite von Bokeh.</li>
				</ul>
				<p>Das <em>Netzdiagramm</em> stellt unterschiedliche Kennzahlen dar, indem ein regelmäßiges n-Eck gebildet wird, dass für jede Kennzahl eine Achse aufweist. Die für die Erstellung des Diagramms benötigten Daten entstammen nur dem aktuellen DBS-Berichtsjahr. Die acht im Netzdiagramm dargestellten Leistungsindikatoren sind nach dem Balanced Scorecard-Ansatz der ISO 11620:2014 angeordnet. Die Achsen des Diagramms reichen dabei für jede Kennzahl von 0 bis zu derem größten Wert. Zur Kontextualisierung der Bibliotheksdaten wird als Vergleich für jede Kennzahl auch der Median eingezeichnet. Die Benennung der einzelnen Bereiche und Kennzahlen sowie ihre numerischen Werte werden in zwei separaten Tabellen dargestellt.</p>
				<p>Die <em>Kennzahlen-Zeitreihen</em> stellen alle Kennzahlen dar, die mit den statistischen Werten der DBS nach den Regeln der Norm ISO 11620:2014 gebildet werden können. Die Werte der betrachteten Bibliothek sind in orange eingetragen. Zur Kontextualisierung wird für jedes Jahr ein Boxplot aus allen Werten dieser Kennzahl berechnet. Der Boxplot setzt sich aus verschiedenen Bestandteilen zusammen:</p>
				<ul>
					<li class="guidanceList"><em>Ausreißer nach oben</em>: Graue Punkte repräsentieren alle Werte, die größer sind als Drittes Quartil + 1,5 Interquartilsabstände (Interquartilsabstand = Drittes Quartil - Erstes Quartil).</li>
					<li class="guidanceList"><em>Oberes Schnurrhaar</em>: Der senkrechte Strich mit dem waagerechten Ende beginnt beim Dritten Quartil und erstreckt sich bis zum größten Wert, der maximal 1,5 Interquartilsabstände vom Dritten Quartil entfernt ist.</li>
					<li class="guidanceList"><em>Drittes Quartil</em>: Der mittlere waagerechte Strich der Box teilt die Menge der Werte so, dass 75% der Werte kleiner und 25% größer als er sind.</li>
					<li class="guidanceList"><em>Zweites Quartil (Median)</em>: Der mittlere waagerechte Strich der Box teilt die Menge der Werte so, dass 50% der Werte kleiner und 50% größer als er sind.</li>
					<li class="guidanceList"><em>Erstes Quartil</em>: Der untere waagerechte Strich der Box teilt die Menge der Werte so, dass 25% der Werte kleiner und 75% größer als er sind.</li>
					<li class="guidanceList"><em>Unteres Schnurrhaar</em>: Der senkrechte Strich mit dem waagerechten Ende beginnt beim Ersten Quartil und erstreckt sich bis zum kleinsten Wert, der maximal 1,5 Interquartilsabstände vom Ersten Quartil entfernt ist.</li>
					<li class="guidanceList"><em>Ausreißer nach unten</em>: Graue Punkte repräsentieren alle Werte, die kleiner sind als Erstes Quartil - 1,5 Interquartilsabstände (Interquartilsabstand = Drittes Quartil - Erstes Quartil).</li>
				</ul>	
			</article>
			<article id="operating_figures">
				<header>
					<h2>Kennzahlen</h2>
				</header>
				<p>DBS-Vis präsentiert Daten der <a href="https://www.bibliotheksstatistik.de/">Deutschen Bibliotheksstatistik (DBS)</a> u. a. in Form von Kennzahlen, wie sie in der Norm <a href="https://www.iso.org/standard/56755.html">ISO 11620</a>, Anhang B definiert sind. Die Leistungsindikatoren werden hierarchisch erst einem der vier Bereiche <em>Ressourcen, Zugang und Infrastruktur</em>, <em>Nutzung</em>, <em>Effizienz</em>, <em>Potenziale und Entwicklung</em> und dann einer der fünf Kategorien <em>Zugang</em>, <em>Bestand</em>, <em>Einrichtungen</em>, <em>Allgemein</em> und <em>Personal</em> zugeordnet. Aus diesen Gegebenheiten leiten sich die Kurzbezeichnungen ab. So steht B.1.3.1 für Anhang B, Bereich Ressourcen, Zugang und Infrastruktur, Kategorie Einrichtungen, erste Kennzahl. Von den 52 so beschriebenen Leistungsindikatoren sind mit den Daten der DBS 9 berechenbar. Dieser werden hier im Einzelnen kurz vorgestellt. Um die Kennzahlen transparent zu machen, werden die jeweiligen Fragebogenfelder der DBS mit deren Nummer in Klammern genannt. Weitere Details zu den Kennzahlen und DBS-Vis finden sich auf der Seite <a href="./background.php">Hintergrund</a>.</p>
				<section id="B.1.3.1">
					<h3>B.1.3.1 Nutzungsfläche zu Primärnutzerschaft</h3>
					<ul>
						<li class="guidanceList"><em>Englische Bezeichnung</em>: User Area per Capita</li>
						<li class="guidanceList"><em>Bereich</em>: Ressourcen, Zugang und Infrastruktur</li>
						<li class="guidanceList"><em>Kategorie</em>: Einrichtungen</li>
						<li class="guidanceList"><em>Berechnung</em>: Die Nutzungsfläche in Quadratmetern wird durch die Größe der Primärnutzerschaft dividiert und mit 1.000 multipliziert.</li>
						<li class="guidanceList"><em>Nutzungsfläche in Quadratmetern</em>: Nutzungsfläche der Bibliothek [12]</li>
						<li class="guidanceList"><em>Größe der Primärnutzerschaft</em>: Studierende [2] + Wissenschaftliches Personal [3]</li>
						<li class="guidanceList"><em>Einheit</em>: Quadratmeter Nutzungsfläche pro 1.000 Mitglieder der Primärnutzerschaft</li>
					</ul>
				</section>
				<section id="B.1.3.2">
					<h3>B.1.3.2 Arbeitsplätze zu Primärnutzerschaft</h3>
					<ul>
						<li class="guidanceList"><em>Englische Bezeichnung</em>: User Places per Capita</li>
						<li class="guidanceList"><em>Bereich</em>: Ressourcen, Zugang und Infrastruktur</li>
						<li class="guidanceList"><em>Kategorie</em>: Einrichtungen</li>
						<li class="guidanceList"><em>Berechnung</em>: Die Anzahl der Benutzerarbeitsplätze wird durch die Größe der Primärnutzerschaft dividiert und mit 1.000 multipliziert.</li>
						<li class="guidanceList"><em>Anzahl der Benutzerarbeitsplätze</em>: Benutzerarbeitsplätze [16]</li>
						<li class="guidanceList"><em>Größe der Primärnutzerschaft</em>: Studierende [2] + Wissenschaftliches Personal [3]</li>
						<li class="guidanceList"><em>Einheit</em>: Benutzerarbeitsplätze pro 1.000 Mitglieder der Primärnutzerschaft</li>
					</ul>
				</section>
				<section id="B.1.4.1">
					<h3>B.1.4.1 Personal zu Primärnutzerschaft</h3>
					<ul>
						<li class="guidanceList"><em>Englische Bezeichnung</em>: Staff per Capita</li>
						<li class="guidanceList"><em>Bereich</em>: Ressourcen, Zugang und Infrastruktur</li>
						<li class="guidanceList"><em>Kategorie</em>: Personal</li>
						<li class="guidanceList"><em>Berechnung</em>: Die Größe des Personals wird durch die Größe der Primärnutzerschaft dividiert und mit 1.000 multipliziert.</li>
						<li class="guidanceList"><em>Größe des Personals</em>: Bibliothekspersonal (Stellen), finanziert durch Mittel des Unterhaltsträgers, in Vollzeitäquivalenten (ohne studentische Hilfskräfte) [215] + Personal, finanziert durch Drittmittel, in Vollzeitäquivalenten (ohne studentische Hilfsmittel) [219] + Studentische Hilfskräfte (unabhängig von der Finanzierung) [221]</li>
						<li class="guidanceList"><em>Größe der Primärnutzerschaft</em>: Studierende [2] + Wissenschaftliches Personal [3]</li>
						<li class="guidanceList"><em>Einheit</em>: Mitarbeitende pro 1.000 Mitglieder der Primärnutzerschaft</li>
					</ul>
				</section>
				<section id="B.2.2.1">
					<h3>B.2.2.1 Bibliotheksbesuche zu Primärnutzerschaft</h3>
					<ul>
						<li class="guidanceList"><em>Englische Bezeichnung</em>: Library Visits per Capita</li>
						<li class="guidanceList"><em>Bereich</em>: Nutzung</li>
						<li class="guidanceList"><em>Kategorie</em>: Zugang</li>
						<li class="guidanceList"><em>Berechnung</em>: Die Anzahl der Bibliotheksbesuche wird durch die Größe der Primärnutzerschaft dividiert.</li>
						<li class="guidanceList"><em>Anzahl der Bibliotheksbesuche</em>: Bibliotheksbesuche [176] + ... Virtuelle Besuche (Visits) Eingabe gesperrt [176.1]</li>
						<li class="guidanceList"><em>Größe der Primärnutzerschaft</em>: Studierende [2] + Wissenschaftliches Personal [3]</li>
						<li class="guidanceList"><em>Einheit</em>: Bibliotheksbesuche pro Mitglied der Primärnutzerschaft</li>
					</ul>
				</section>
				<section id="B.2.2.5">
					<h3>B.2.2.5 Schulungsbesuche zu Primärnutzerschaft</h3>
					<ul>
						<li class="guidanceList"><em>Englische Bezeichnung</em>: Number of User Attendances at Training Lessons per Capita</li>
						<li class="guidanceList"><em>Bereich</em>: Nutzung</li>
						<li class="guidanceList"><em>Kategorie</em>: Zugang</li>
						<li class="guidanceList"><em>Berechnung</em>: Die Anzahl der Schulungsteilnahmen wird durch die Größe der Primärnutzerschaft dividiert und mit 1.000 multipliziert.</li>
						<li class="guidanceList"><em>Anzahl der Schulungsteilnahmen</em>: Teilnehmer an Benutzerschulungen [178] + Aufrufe von E-Learning-Angeboten der Bibliothek [178.1]</li>
						<li class="guidanceList"><em>Größe der Primärnutzerschaft</em>: Studierende [2] + Wissenschaftliches Personal [3]</li>
						<li class="guidanceList"><em>Einheit</em>: Schulungsteilnahmen pro 1.000 Mitglieder der Primärnutzerschaft</li>
					</ul>
				</section>
				<section id="B.3.1.2">
					<h3>B.3.1.2 Erwerbungskosten pro Bestandsnutzung</h3>
					<ul>
						<li class="guidanceList"><em>Englische Bezeichnung</em>: Acquisition Cost per Collection Use</li>
						<li class="guidanceList"><em>Bereich</em>: Effizienz</li>
						<li class="guidanceList"><em>Kategorie</em>: Bestand</li>
						<li class="guidanceList"><em>Berechnung</em>: Die Erwerbungskosten in Euro werden durch die Anzahl der Bestandsnutzungen dividiert.</li>
						<li class="guidanceList"><em>Erwerbungskosten in Euro</em>: Erwerbung gesamt [149]</li>
						<li class="guidanceList"><em>Anzahl der Bestandsnutzungen</em>: Entleihungen nach physischen Einheiten insgesamt [167] - Entleihungen, davon: Verlängerungen auf Benutzerantrag [170] + Präsenzbenutzungen [174] + Vollanzeige von Zeitschriftenartikeln [183] + Vollanzeige von digitalen Einzeldokumenten [184] + Positiv erledigte aktive Bestellungen insgesamt [191]</li>
						<li class="guidanceList"><em>Einheit</em>: Euro Erwerbungskosten pro Bestandsnutzung</li>
					</ul>
				</section>
				<section id="B.3.4.1">
					<h3>B.3.4.1 Kosten pro aktiv Nutzende</h3>
					<ul>
						<li class="guidanceList"><em>Englische Bezeichnung</em>: Cost per User</li>
						<li class="guidanceList"><em>Bereich</em>: Effizienz</li>
						<li class="guidanceList"><em>Kategorie</em>: Allgemein</li>
						<li class="guidanceList"><em>Berechnung</em>: Die Gesamtausgaben in Euro werden durch die Anzahl derer dividiert, die im Berichtsjahr mindestens einmal etwas entliehen haben.</li>
						<li class="guidanceList"><em>Gesamtausgaben in Euro</em>: Erwerbung gesamt [149]</li>
						<li class="guidanceList"><em>Anzahl derer, die im Berichtsjahr mindestens einmal etwas entliehen haben</em>: Entleihende [4]</li>
						<li class="guidanceList"><em>Einheit</em>: Euro Gesamtausgaben pro Personen oder Institutionen, die im Berichtsjahr mindestens einmal etwas entliehen haben</li>
					</ul>
				</section>
				<section id="B.4.2.3">
					<h3>B.4.2.3 Schulungsstunden zu Bruttoarbeitszeit</h3>
					<ul>
						<li class="guidanceList"><em>Englische Bezeichnung</em>: Percentage of Staff Time Spent in Training</li>
						<li class="guidanceList"><em>Bereich</em>: Potenziale und Entwicklung</li>
						<li class="guidanceList"><em>Kategorie</em>: Personal</li>
						<li class="guidanceList"><em>Berechnung</em>: Die Schulungsstunden des Personals werden durch die Bruttoarbeitszeit des Personals dividiert und mit 100 multipliziert.</li>
						<li class="guidanceList"><em>Schulungsstunden des Personals</em>: Fortbildungstage aller Mitarbeiter [223] * 8 Stunden</li>
						<li class="guidanceList"><em>Bruttoarbeitszeit des Personals</em>: (Bibliothekspersonal (Stellen), finanziert durch Mittel des Unterhaltsträgers, in Vollzeitäquivalenten (ohne studentische Hilfskräfte) [215] + Personal, finanziert durch Drittmittel, in Vollzeitäquivalenten (ohne studentische Hilfsmittel) [219] + Studentische Hilfskräfte (unabhängig von der Finanzierung) [221]) * 2080 Stunden</li>
						<li class="guidanceList"><em>Einheit</em>: Prozent Schulungsstunden des Personals zur Bruttoarbeitszeit des Personals</li>
					</ul>
				</section>
				<section id="B.4.3.1">
					<h3>B.4.3.1 Sonderzuschüsse und selbst generierte Einnahmen zu Gesamtbudget</h3>
					<ul>
						<li class="guidanceList"><em>Englische Bezeichnung</em>: Percentage of Library Means Received by Special Grant or Income Generated</li>
						<li class="guidanceList"><em>Bereich</em>: Potenziale und Entwicklung</li>
						<li class="guidanceList"><em>Kategorie</em>: Allgemein</li>
						<li class="guidanceList"><em>Berechnung</em>: Die Dritt- und selbst erwirtschafteten Mittel werden durch das Gesamtbudget dividiert und mit 100 multipliziert.</li>
						<li class="guidanceList"><em>Dritt- und selbst erwirtschaftete Mittel</em>: Finanzierung durch Drittmittel [164] + Selbst erwirtschaftete Mittel [165]</li>
						<li class="guidanceList"><em>Gesamtbudget</em>: Mittel insgesamt [166]</li>
						<li class="guidanceList"><em>Einheit</em>: Prozent Dritt- und selbst erwirtschafteten Mittel zum Gesamtbudget</li>
					</ul>
				</section>				
			</article>			
			<article id="search">
				<header>
					<h2>Suche</h2>
				</header>
				<p>Die Suche ermöglicht den Zugang zu den Daten der einzelnen Bibliotheken der DBS-Jahrgänge 2018 und 2019. Sie besteht aus zwei getrennten Bereichen: der <em><a href="./search.php#map">Karte</a></em> und der <em><a href="./search.php#list">Liste</a></em>.</p>
				<p>Die <em>Karte</em> bietet für alle Bibliotheken einen Marker an. Klickt man auf einen Marker, öffnet sich ein Textfenster und der Name der Bibliothek, wie er in der DBS verwendet wird, erscheint. Dieser Name ist ein Link zur individuellen Datenseite für die Bibliothek.</p>
				<p>Die <em>Liste</em> ist ein aufklappbares Formular und enthält alle Bibliotheksnamen. Zum Aufrufen der individuellen Datenseite für die Bibliothek, muss zuerst auf den Namen der Bibliothek in der aufgeklappten Liste und danach auf den Button "Finden" geklickt werden.</p>
			</article>
		</main>
<?php
	require './requires/footer.php';
?>		
