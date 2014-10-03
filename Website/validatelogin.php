<?php
	session_start();

	// Your database info
	$db_host = '127.0.0.1';
	$db_user = 'untergru_consult';
	$db_pass = '%4KyAHvVGxX%F3*uik';
	$db_name = 'untergru_consult';

	$con = new mysqli($db_host, $db_user, $db_pass, $db_name);
	
	if ($con->connect_error)
	{
		die('Connect Error (' . $con->connect_errno . ') ' . $con->connect_error);
	}

	$username = $_POST['username'];
	$password = $_POST['password'];


	$sql = "SELECT * FROM `account` WHERE username = '$username' AND password = '$password'";
	$result = mysqli_query($sql);

	//Check whether the query was successful or not
	if($result) {
		if(mysqli_num_rows($result) > 0) {
			//Login Successful
			header("location: player0.php");
			exit();
		}else {
			//Login failed
				header("location: index.php");
				exit();
			}
		}
?>