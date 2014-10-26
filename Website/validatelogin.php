<?php
session_start();
?>

<html>
<body>
    
<?php

	// CheckMate database info
	$db_host  = 'mysql.cs.iastate.edu';
	$db_user  = 'u309M13';
	$db_pass  = 'T2GWRYDIw';
	$db_name  = 'db309M13';
	$tbl_name = 'Account'; 
	
	//Create connection
	$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

	// Check connection
	if ($conn->connect_error) {
 	   die("Connection failed: " . $conn->connect_error);
	}
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$sql      = "SELECT * FROM $tbl_name WHERE username = '$username' and password = '$password'";
	$result   = $conn->query($sql);

	// If result matched $username and $password, table row must be 1 row
	if ($result->num_rows === 1)
    {
        echo "successful query";
        if ($row = $result->fetch_assoc()){
                $id = $row["id"];
                echo "<br> Username: " . $row["username"] . " - Password: " . $row["password"];
        }
		// Store player's info in the superglobal _SESSION with key "player", and redirect to file "player0.php"
        $_SESSION["player"]=new Player($row["id"],$row["username"],$row["password"],$row["name"],$row["email"]);
		header("location:player0.php");
    }
	else
    {
		echo "I'm disabled. Wrong Username or Password. Please retry.";
    }
    $conn->close();
?>

</body>
</html> 