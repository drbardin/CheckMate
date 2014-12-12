<?php
    include "classPlayer.php";
    session_start();

if($_SESSION["login"])
{
    
    ?>

<html lang="en">

	<head>
        <link rel="stylesheet" type="text/css" href="website.css">
		<title>The King | Checkmate</title>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
        <h2 id = "usertop" >The King</h2>        
            
        <div class = "piecetutorial" >
            <img class = "queen" src = "king.png" alt = "King">          
            <div class = "queenbox" class = "textbox">
                <p>    
                    <br><br>This is the King, the most important piece in the game. The object of the game is to trap the opponent's king so that its escape is not possible. The poor king can only move one space at a time in any direction, making it possibly the weakest piece.<br /><br /></p>
            </div>
            <div class = "inline">
                <a href="piece_queenmove.php"><input type="imgforback" value="Previous"></a>
                <a href="piece_kingmove.php"><input type="imgforback" value="Next"></a>
            </div>
        </div>
		<br />
		<br />
		<br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
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