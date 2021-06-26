<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Random Comic Book</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>
<body>
	<div id="wrap">
		<div id="topcontainer">
			&nbsp;
		</div>
		<div id="container">
			<div id="banner">
				<h1> <a href="./">Comic World</a></h1>
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
				<h1>Random Comic</h1>
				<p><strong>Number</strong>: </p>
                <p><strong>Comic Title</strong>:  </p>
                <p><strong>Link</strong>:  </p>
                <p><strong>Image</strong>: </p>
			</div>

			<div>
			</div>

			<div id="footer">
				<form name="subscribe" action="retrieve.php" method="POST">
					<input type="text" name="email_id" placeholder="Enter Your Email ID" required>&nbsp;&nbsp;
					<button type="submit" name="submit"> Subscribe </button>
				</form>
				<p><a rel="license" href="http://creativecommons.org/licenses/by-nc/2.5/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/2.5/80x15.png" /></a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/2.5/">Creative Commons Attribution-NonCommercial 2.5 Generic License</a>.</p>
			</div>
		</div>
	</div>
</body>
</html>