<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Comic World</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css" />
	<!--script type="text/javascript" src="./script/script.js"></script-->
</head>
<body>
	<div id="wrap">
		<div id="topcontainer">
			&nbsp;
		</div>
		<div id="container">
			<div id="banner">
				<h1> <a href="./">Welcome to Comic World</a></h1>
			</div>
		</div>
		<div id="container2">
			<div id="left">
				<div id="nav">
					<ul>
						<li><a href="./"><span>Home</span></a></li>
						<li><a href="./comic.php"><span>Comic</span></a></li>
					</ul>
				</div>
			</div>
			<div id="content">
				<h1>What is Comic Book?</h1>
				<p>A magazine that presents a serialized story in the form of a comic strip, typically featuring the adventures of a superhero.</p>
				<h1>Why are they called Comics?</h1>
				<p>They were called comics or "funnies" because the were, for the most part, comical stories meant for light entertainment. The first "comic books" were collected versions of comic strips that appeared in newspapers.</p>
				<br>
			</div>

			<div>
			</div>

			<div id="footer">
				<form name="subscribe" action="./include/subscribe_check.php" method="POST">
					<input type="email" name="email_id" placeholder="Enter Your Email ID" required>&nbsp;&nbsp;
					<button type="submit" name="submit"> Subscribe </button>
				</form>
				<p><a rel="license" href="http://creativecommons.org/licenses/by-nc/2.5/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/2.5/80x15.png" /></a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/2.5/" target="_black"><i>Creative Commons Attribution-NonCommercial 2.5 Generic License</i></a>.</p>
			</div>
		</div>
	</div>
</body>
</html>