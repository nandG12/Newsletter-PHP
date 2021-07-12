<?php
	header('refresh:15; url=index.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Comic World</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css" />
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
				<?php
					if(!isset($_GET['retrieve'])){
				?>
				<h1>Success! You're almost done. <img src="https://www.freepnglogos.com/uploads/email-png/file-email-icon-svg-wikimedia-commons-20.png" width="20" alt="file email icon svg wikimedia commons" /></h1>
                <p>A Verification link has sent to your email account. </p>
                <p>Please click on the link that has been sent to your email and hurrah!! Enjoy Comics in mail.</p> 
                <p>Thank you for your interest!</p>
                <?php
                	}
                	elseif($_GET['retrieve'] == 'asubscribed'){
                ?>
                <h1>You Have Already Subscribed.</h1>
                <p>Thank you for your interest!</p>
                <?php
                	}
                	elseif($_GET['retrieve'] == 'unsubscribed'){
                ?>
                <h1>Sorry to see you go.</h1>
                <p>You have successfully unsubscribed from our newsletter.</p>
				<p>Your email address has also been removed from our mailing list. You will receive no more emails from us.</p>
				<p>If you have unsubscribed by mistake or you have typed in the wrong email address, please feel free to register again at any time.</p>
                <?php
                	}
                	elseif($_GET['retrieve'] == 'verified'){
                ?>
                <h1>Thanks for being awesome!</h1>
                <p>You've successfully verified your email. Enjoy the Comics!!</p>
			  	<?php
                	}
                	elseif($_GET['retrieve'] == 'vfail'){
                ?>
                <h1>Looks Like You haven't verified your account.</h1>
                <p>Please verify your email first.</p>

                <?php
                	}
                	else{
                ?>
                <h1>Something went wrong.</h1>
               	<?php
                	}
                ?>
                <p align="right">You will be Redirecting to the Home Page</p>
			</div>

			<div>
			</div>

			<div id="footer">
				<p><a rel="license" href="http://creativecommons.org/licenses/by-nc/2.5/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/2.5/80x15.png" /></a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/2.5/" target="_black"><i>Creative Commons Attribution-NonCommercial 2.5 Generic License</i></a>.</p>
			</div>
		</div>
	</div>
</body>
</html>