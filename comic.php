<?php
		function random_comic_url(){
            $random_comic = rand(0,2478);
            $json = file_get_contents("https://xkcd.com/$random_comic/info.0.json");
            $data = json_decode($json);

            //Store Value in Array
            $comic_data = array("URL"=> $data->img, "title"=> $data->title, "alt_text"=> $data->alt, "num"=>$data->num, "attachment_name"=> parse_url($data->img, PHP_URL_PATH));
            return $comic_data; 
    	}

    $comic_data = random_comic_url();
    $comic_image_URL = $comic_data['URL'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Random Comic Book</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css" />
	<script type="text/javascript" src="./script/script.js"></script>
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
				<p><strong>Number</strong>: <?php echo $comic_data['num']; ?></p>
                <p><strong>Comic Title</strong>: <?php echo $comic_data['title']; ?> </p>
                <p><strong>Link</strong>: <?php echo $comic_data['URL']; ?> </p>
                <p><strong>Image</strong>: </p>
                <?php echo "<img border='0' alt='XKCD Cartoon' src=$comic_image_URL>"; ?> 
			</div>

			<div>
			</div>

			<div id="footer">
				<form name="subscribe" action="./include/subscribe_check.php" method="POST" onsubmit="return validateEmail();">
					<input type="text" name="email_id" placeholder="Enter Your Email ID" required>&nbsp;&nbsp;
					<button type="submit" name="submit"> Subscribe </button>
				</form>
				<p><a rel="license" href="http://creativecommons.org/licenses/by-nc/2.5/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/2.5/80x15.png" /></a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/2.5/">Creative Commons Attribution-NonCommercial 2.5 Generic License</a>.</p>
			</div>
		</div>
	</div>
</body>
</html>