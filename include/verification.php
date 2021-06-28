<?php
	//Check if Verification, Email & Random Key Added in URL or NOT
	if(isset($_GET['rid']) && isset($_GET['eid']) && isset($_GET['vid']) && $_GET['rid']!= NULL && $_GET['eid']!= NULL && $_GET['vid']!= NULL ) {

		$rid = $_GET['rid'];
		$eid = $_GET['eid'];
		$vid = $_GET['vid'];	

		//Import DB Connection
		include './db_connection.php';

		//Fetch the Email ID From that Account using vkey
		$verify_select_sql = "SELECT email,verified,verification_key FROM accounts WHERE random_id = '$rid' LIMIT 1";

		$result_of_verify_select = mysqli_query($db_connection, $verify_select_sql);

		if( mysqli_num_rows($result_of_verify_select) == 1){

			//Check if Email ID & Verification key is correct or not
			$verify_data = mysqli_fetch_assoc($result_of_verify_select);
			if(md5($verify_data['email']) == $eid && md5($verify_data['verification_key']) == $vid){

				//Update the Database If Random ID Matched 
				$verification_update_sql = "UPDATE accounts SET verified = 1, subscribed = 1 WHERE random_id = '$rid' LIMIT 1";
				$result_of_verification_update = mysqli_query($db_connection, $verification_update_sql);

				if ($result_of_verification_update) {
					header("Location: ../retrieve.php?retrieve=verified");
					exit();
				}
				else{
					header("Location: ../retrieve.php?retrieve=fail");
					exit();
				}
			}//If Email or Verification Key Doesn't Match
			else{
				header("Location: ../retrieve.php?retrieve=fail");
				exit();
			}
		}//If Email ID Already Verified
		else{
			header("Location: ../retrieve.php?retrieve=fail");
			exit();
		}
	}//If Variable is not set properly in URL then Redirect to login page with 
	else{
		header("Location: ../retrieve.php?retrieve=fail");
		exit();
	}
?>

     