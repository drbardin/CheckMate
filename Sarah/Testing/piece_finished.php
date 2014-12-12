<?php
    include "classPlayer.php";
    session_start();

if($_SESSION["login"])
{
    
    ?>

<html lang="en">

	<head>
        <link rel="stylesheet" type="text/css" href="website.css">
		<title>Choose a Tutorial | Checkmate</title>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
		<br />
        <h2 id = "usertop" >You have completed the first tutorial!</h2>
        
            <h2 id = "subtop" >You can now move on to the next one, or go play to your home page.</h2>
        <div class = "endusertutorial" >
                <a href = "pvai.php"><input type="posttutorialpage" value="Up Next: How to Play"></a>
                <br>
                <br>
                <br>
                <a href="player0.php"><input type="posttutorialpage" value="Return Home"></a>
        </div>
        <br>
		<footer>
            <div class = "footerbuttons">
               <a href="options.php"><img src="options.png"></a>
            </div>
            <div class = "logoutbutton">
                 <a href = "logout.php"><input type="logout" value="Logout"></a>
            </div>
		</footer>

	</body>

</html>

<?php
}
else{
    echo 'You are not logged in. <a href = "login.php">Click here</a> to log in.';
}
?>