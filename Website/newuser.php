<?php

$con = mysqli_connect("mysql.cs.iastate.edu","u309M13","T2GWRYDIw", "db309M13");

// Check connection
if (mysqli_connect_errno()) 
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// escape variables for security
$fullname = mysqli_real_escape_string($con, $_POST['fullname']);
$username = mysqli_real_escape_string($con, $_POST['username']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$email    - mysqli_real_escape_string($con, $_POST['email']); 

$sql="INSERT INTO Users (fullname, username, password, email);
VALUES ('$fullname', '$username', '$password', '$email')";

if (!mysqli_query($con,$sql)) {
  die('Error: ' . mysqli_error($con));
}
echo "1 record added";

mysqli_close($con);
?>