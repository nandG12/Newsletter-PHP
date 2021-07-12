<?php
	//This is the MYSQL Database Connection File. We Will include this file whenever we need to do database Operations.
	
	/*Create 'accounts' Table with Following Attribute & Column Name.
		CREATE TABLE accounts (
		  email varchar(150) PRIMARY KEY,
		  verification_key varchar(150),
		  verified tinyint(5) DEFAULT 0,
		  subscribed tinyint(5) DEFAULT 0,
	      random_id int(30),
		  create_date timestamp
		);
	*/

	// Change the Value Accroding to your MYSQL Configuration. Below is an Simple Example.
	$db_URL = 'localhost';
	$db_username = 'root';
	$db_password = '';
	$db_databaseName = 'comic-world';

	//Connecting
	$db_connection = mysqli_connect($db_URL, $db_username, $db_password, $db_databaseName);

	//If the connection failed for any reason (such as wrong username and or password), we will print the error below and stop execution of the rest of this php script
	if(!$db_connection){
		die('Connection Failed With MYSQL Please Contact Your Administrator for more details');
	}
?>