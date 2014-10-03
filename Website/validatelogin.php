<?php

	session_start();

	// Your database info
	$db_host = '127.0.0.1';
	$db_user = 'untergru_consult';
	$db_pass = '%4KyAHvVGxX%F3*uik';
	$db_name = 'untergru_consult';
	$tbl_name = 'account'; 
	
	$con = mysql_connect($db_host, $db_user, $db_pass, $db_name)or die("Cannot connect");
	mysql_select_db("$db_name")or die("Cannot select DB"); 
	
	$username = $_POST['username'];
	$password = $_POST['password'];

	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	
	$sql="SELECT * FROM $tbl_name WHERE username = '$username' and password = '$password'";
	$result = mysql_query($sql);

	// Mysql_num_row is counting table row
	$count = mysql_num_rows($result);

	// If result matched $username and $password, table row must be 1 row
	if($count==1){
		// Register $username, $password and redirect to file "player0.php"
		session_register("username");
		session_register("password"); 
		header("location:player0.php");
	}
	else {
		echo "I'm disabled. Wrong Username or Password. Please retry.";
	}
?>