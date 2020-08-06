		</main>
		<?php
			$pages = [
				[
					'name' => 'stop',
					'linktext' => 'Kontaktformular',
				],
				[
					'name' => 'impressum',
					'linktext' => 'Impressum',
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
		<footer>
			<ul>
				<?php
					foreach ($pages as $page) : echo $page["listitem"];
					endforeach;
				?>
				<li>Stand: 06.08.2020</li>
				<li><a href="https://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px" src="https://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS ist valide!" /></a></li>
			</ul>
		</footer>
	</body>
</html>