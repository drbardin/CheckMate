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
        <h2 id = "usertop" >The Queen</h2>        
            
        <div class = "piecetutorial" >
            <img class = "queen" src = "Queen.png" alt = "Queen">          
            <div class = "queenbox" class = "textbox">
                <p>    
                    <br>
                    <br>
                    <br>This is the queen, the most power piece in the game. The queen can move any number of spaces horizontally, vertically, or diagonally.<br /><br /></p>
            </div>
            <div class = "inline">
            <a href="piece_bishopmove.php"><input type="imgforback" value="Previous"></a>
             <a href="piece_queenmove.php"><input type="imgforback" value="Next"></a>
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