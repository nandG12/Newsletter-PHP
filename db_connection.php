<?php
	//This is the Database Connection File. We Will include this file whenever we need to do database Operations.
	
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

	// Below we are setting up our connection to the server. 
	$db_URL = "localhost";
	$db_username = "root";
	$db_password = "";
	$db_databaseName = "comicworld";

	//Connecting
	$db_connection = mysqli_connect($db_URL, $db_username, $db_password, $db_databaseName);

	//If the connection failed for any reason (such as wrong username and or password), we will print the error below and stop execution of the rest of this php script
	if(!$db_connection){
		die('Connection Failed With MYSQL Please Contact Your Administrator for more details');
	}
?>