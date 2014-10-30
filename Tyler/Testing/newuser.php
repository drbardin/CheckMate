<?php

// Your database info
$db_host = 'mysql.cs.iastate.edu';
$db_user = 'u309M13';
$db_pass = 'T2GWRYDIw';
$db_name = 'db309M13';
$tbl_name = 'Account'; 

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//escape variables for security
$name 	  = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$email    = $_POST['email']; 

//Change to match database name and variables
$sql="INSERT INTO Account (name, username, password, email) VALUES ('$name', '$username', '$password', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?> 