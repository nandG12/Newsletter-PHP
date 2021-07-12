<?php
	//Import DB Connection	& PHP Mailer Confige
	include __DIR__.'/db_connection.php';
    include __DIR__.'/mail_config.php';

	//Fetch the Current URL
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){  
		$address = "https://";
	}
	else{  
		$address = "http://";
	}

	// Append the host(domain name, ip) to the URL.   
	$address .= isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : NULL;

	//Check All Fields are Enter & Validate the Data
	if(isset($_POST['email_id'])) {

		//Function to Validate the Data in PHP Again
		function validate($data){
			$data = trim($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		$email = validate($_POST['email_id']);

		/*Sanitize the Data*/
		$email = mysqli_real_escape_string($db_connection, $email);

		//Check if Email ID was Already Register or not
        $select_sql = "SELECT * FROM accounts WHERE email='$email'";
        $result_of_select = mysqli_query($db_connection, $select_sql);

		if (mysqli_num_rows($result_of_select) > 0){
			$resend_data = mysqli_fetch_assoc($result_of_select);

			if($resend_data['subscribed'] == 1 && $resend_data['verified'] == 1){
	        	header('Location: ../retrieve.php?retrieve=asubscribed');
	        	exit();
			}
			else {
				$resend_secure_email = md5($resend_data['email']);
	        	$resend_secure_vkey = md5($resend_data['verification_key']);
	        	$resend_random_id = $resend_data['random_id'];

				//Create Mail
		        $mail->ClearAllRecipients();
		        $mail->addAddress($email);
		        $mail->isHTML(true);
		        $mail->Subject= 'Resend Verification Link : Comic World';
        		$mail_body = <<<EOD
					<!DOCTYPE html>
					<html>
					<head>
					</head>
					<body>
					<div>
					    <table width="100%" border="0" cellspacing="0" cellpadding="0">
					        <tbody><tr>
					            <td scope="row">
					                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #f3a801;padding:5px;margin-top:5px">
					                    <tbody><tr>
					                        <td>
					                            <p>
					                                <h4>Hello,</h4>
					                                You are almost ready to start reading Comic books. 
					                                Simply click on the Link to verify your email address.
					                            </p>
					                            <p>
					                                <a href='$address/include/verification.php?rid=$resend_random_id&eid=$resend_secure_email&vid=$resend_secure_vkey' target="_blank"> $address/include/verification.php?rid=$resend_random_id&eid=$resend_secure_email&vid=$resend_secure_vkey </a>
					                            </p>
					                            <p>
					                                Thanks,<br>
					                                Team Comic
					                            </p>
					                            <p>
					                                Note: This is an auto-generated mail. Please do not reply to this email.
					                            </p>
					                        </td>
					                    </tr>
					                </tbody></table>
					            </td>
					        </tr>
					        <tr>
					            <td height="5"></td>
					        </tr>
					    </tbody></table>
					</body>
					</html>
				EOD;
				$mail->Body=$mail_body;
		        $mail->send();
        		//Redirect to the Sign-UP Page with Success Message
        		header('Location: ../retrieve.php');
	         	exit();
	        }
        }
        else{
        	//Generate the Email Verification Key

        	//We are using the Current time stamp & Username to Generate the Verification Key
        	$vkey = md5(time().$email);

        	//Random Key Generated Using s-Seconds, i-Minutes, H-24-hour format of an hour, d-The day of the month, N-The ISO-8601 numeric representation of a day
        	$server_time = isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time();
        	$random_id = date('siHdN', $server_time);

        	//Insert the data into the Database
        	$insert_sql = "INSERT INTO accounts(email, verification_key, random_id) VALUES('$email', '$vkey', '$random_id')";
        	$result_of_insert = mysqli_query($db_connection, $insert_sql);

        	if ($result_of_insert) {
        		//As a Security token we convert Email & Verification key into md5 & Send Mail
        		$secure_email = md5($email);
        		$secure_vkey = md5($vkey);

				//Create Mail
		        $mail->ClearAllRecipients();
		        $mail->addAddress($email);
		        $mail->isHTML(true);
		        $mail->Subject= 'Email Verification : Comic World';
        		$mail_body = <<<EOD
					<!DOCTYPE html>
					<html>
					<head>
					</head>
					<body>
					<div>
					    <table width="100%" border="0" cellspacing="0" cellpadding="0">
					        <tbody><tr>
					            <td scope="row">
					                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #f3a801;padding:5px;margin-top:5px">
					                    <tbody><tr>
					                        <td>
					                            <p>
					                                <h4>Hello,</h4>
					                                You are almost ready to start reading Comic books. 
					                                Simply click on the link to verify your email address.
					                            </p>
					                            <p>
					                                <a href='$address/include/verification.php?rid=$random_id&eid=$secure_email&vid=$secure_vkey' target="_blank"> $address/include/verification.php?rid=$random_id&eid=$secure_email&vid=$secure_vkey </a>
					                            </p>
					                            <p>
					                                Thanks,<br>
					                                Team Comic
					                            </p>
					                            <p>
					                                Note: This is an auto generated mail. Please do not reply to this email.
					                            </p>
					                        </td>
					                    </tr>
					                </tbody></table>
					            </td>
					        </tr>
					        <tr>
					            <td height="5"></td>
					        </tr>
					    </tbody></table>
					</body>
					</html>
				EOD;
				$mail->Body=$mail_body;
		        $mail->send();
        		
        		//Redirect to the Sign-UP Page with Success Message
        		header('Location: ../retrieve.php');
	         	exit();
        	}
        	else{
        		//If Something goes wrong while insert into DB
        		header('Location: ../retrieve.php?retrieve=vfail');
	         	exit();
        	}
        }
	}
	else{
		header('Location: ../index.php');
		exit();
	}
?>