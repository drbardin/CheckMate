<?php
include "classPlayer.php";
session_start();
?>

<html>
<body>
 
<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);

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
        if ($row = $result->fetch_assoc())
        {
            // Store player's info in the superglobal $_SESSION with key "player", and redirect to file "player0.php"
            $player = new Player($row["ID"],$row["username"],$row["password"],$row["name"],$row["email"]);
            $_SESSION["player"]=$player;
 	        header("location:player0.php");
        }
    }
	else
    {
		echo "Wrong Username or Password. Please press the back button.";
    }
    $conn->close();
?>

</body>
</html> 