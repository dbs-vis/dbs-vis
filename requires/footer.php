		<footer>
			<ul>
				<?php
					foreach ($pages as $page) {
						if ($page["place"] == "footer") {
							echo $page["listitem"];
						};
					};
				?>
				<li>Stand: 25.10.2020</li>
				<li>
					<a href="https://jigsaw.w3.org/css-validator/check/referer">
						<img id="css-validator" src="https://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS ist valide!" />
					</a>
				</li>
			</ul>
		</footer>
	</body>
</html>