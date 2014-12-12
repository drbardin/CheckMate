<?php
    include "classPlayer.php";
    session_start();

if($_SESSION["login"])
{
    
    ?>

<html lang="en">

	<head>
        <link rel="stylesheet" type="text/css" href="website.css">
		<title>The Rook | Checkmate</title>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
        <h2 id = "usertop" >The Rook</h2>        
            
        <div class = "piecetutorial" >
            <img class = "rook" src = "rook.png" alt = "Rook">          
            <div class = "piecebox">
                <p><br>   This is the rook. Each player starts the game with two, one in each of the corner squares on their own side of the board. <br><br>The rook moves horizontally or vertically, through any number of unoccupied squares. As with captures by other pieces, the rook captures by occupying the square on which the enemy piece sits. <br><br>The rook also participates, with the king, in a special move called castling, but we will discuss this move in a later tutorial.</p>
            </div>
            <div class = "inline">
            <a href="pawn_topiece.php"><input type="imgforback" value="Previous"></a>
             <a href="piece_rookmove.php"><input type="imgforback" value="Next"></a>
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