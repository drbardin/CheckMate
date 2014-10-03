<?php

$con = mysqli_connect("127.0.0.1","untergru_consult","%4KyAHvVGxX%F3*uik", "untergru_consult");

// Check connection
if (mysqli_connect_errno()) 
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// escape variables for security
$name 	  = mysqli_real_escape_string($con, $_POST['name']);
$username = mysqli_real_escape_string($con, $_POST['username']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$email    = mysqli_real_escape_string($con, $_POST['email']); 

//Change to match database name and variables
$sql="INSERT INTO account (ID, name, username, password, email) 
	VALUES (NULL, '$name', '$username', '$password', '$email')";


if (!mysqli_query($con, $sql)) {
  die('Error: ' . mysqli_error($con));
}
echo "Registration successful. Please Login.";

mysqli_close($con);

?>