<?php

mysqli_connect("mysql.cs.iastate.edu","u309M13","T2GWRYDIw", "db309M13");

if(mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysql_error();
} 

$ID = $_POST['username'];
$PD = $_POST['password'];

function SignIn()
{
	session_start();
	if(!empty($ID))
	{
		$query = mysqli_query("SELECT * FROM Username where username = '$ID' AND password = '$PD'") or die(mysqli_error());
		$row = mysqli_fetch_array($query) or die(mysqli_error());

		if(!empty($row['username']) AND !empty($row['password']))
		{
			$_SESSION['username'] = $row['pass']; 
			header('location:player0.php'); 
			
		}
		else
		{
			echo "I'm disabled. Retry."; 
		}
	}
}

if(isset($_POST['submit']))
{
	SignIn();
}

?>