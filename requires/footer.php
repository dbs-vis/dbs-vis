		<footer>
			<ul>
				<?php
					foreach ($pages as $page) {
						if ($page["place"] == "footer") {
							echo $page["listitem"];
						};
					};
				?>
				<li>Stand: 19.10.2020</li>
				<li>
					<a href="https://jigsaw.w3.org/css-validator/check/referer">
						<img style="border:0;width:88px;height:31px" src="https://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS ist valide!" />
					</a>
				</li>
			</ul>
		</footer>
	</body>
</html>