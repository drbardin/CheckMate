<?php
    include "classPlayer.php";
    session_start();

if($_SESSION["login"])
{
    
    ?>

<html lang="en">

	<head>
        <link rel="stylesheet" type="text/css" href="website.css">
		<title>The Pawn | Checkmate</title>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
        <h2 id = "usertop" >The Pawn</h2>        
            
        <div class = "piecetutorial" >
            <img class = "pawn" src = "white_pawn.png" alt = "Pawn">          
            <div class = "piecebox">
                <p>This is the pawn, the chess piece of the smallest size and value. <br /><br />A pawn moves one square forward along its file if unobstructed (or two on the first move), or one square diagonally forward when making a capture. <br /><br />Each player begins with eight pawns on the second rank, and can promote a pawn to become any other piece (typically a queen) if it reaches the opponent's end of the board.</p>
            </div>
            <div class = "inline">
            <a href="pre_tutorial.php"><input type="imgforback" value="Previous"></a>
             <a href="piece_pawnmove.php"><input type="imgforback" value="Next"></a>
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