<?php

// Your database info
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'root';
$db_name = 'db309M13';
$db_port = 8889;
$tbl_name = 'Account'; 

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

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
    
    echo '<script type = "text/javascript">'; 
    echo 'alert("Registration successful! Please login.")';
    echo '</script>';
    header("refresh: 0.5; url = login.php");
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?> 