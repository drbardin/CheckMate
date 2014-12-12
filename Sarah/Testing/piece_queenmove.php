<?php
    include "classPlayer.php";
    session_start();

if($_SESSION["login"])
{
    
    ?>

<html lang="en">

	<head>
        <link rel="stylesheet" type="text/css" href="website.css">
		<title>The Queen | Checkmate</title>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
        <h2 id = "usertop" >The Queen's Movement</h2>        
            
        <div class = "chesspawntutorial" >
            <div class = "chessqueenbox">
                <p><br>The Queen can move in any direction for any number of spaces. </p>
            </div>
                 <img class = "chessboard" src = "queen_movements.png" alt = "chessboard">
            <br />
            <br />
            <br />
            <div class = "inline">
            <a href="eachpiece_queen.php"><input type="tutorialforback" value="Previous"></a>
             <a href="eachpiece_king.php"><input type="tutorialforback" value="Next"></a>
            </div>
        </div>
        <br />
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