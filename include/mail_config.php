<?php
	/**
	
	//Import the PHP Mailer Library
	require dirname(__DIR__, 1).'/lib/phpmailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;
	$mail->isSMTP();

	//Change the SMTP Configuration as per your mail provider. Below is an example of the Google Mail SMTP Configuration.
	$mail->Host='smtp.gmail.com';
	$mail->Port=587;
	$mail->SMTPAuth=true;
	$mail->SMTPSecure='TLS';

	//Enter Your E-Mail Username & Password
	$mail->Username='';
	$mail->Password='';

	//Enter the E-Mail that you are using
	$mail->setFrom('xxx@xxx.com');
	$mail->addReplyTo('xxx@xxx.com');
	
	**/

	//When Using the in-built PHP mail() Function
	$from = 'xxx@xxx.com'; 
	$fromName = 'Comic World';
?>