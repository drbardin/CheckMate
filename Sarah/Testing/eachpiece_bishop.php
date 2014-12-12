<?php
    include "classPlayer.php";
    session_start();

if($_SESSION["login"])
{
    
    ?>

<html lang="en">

	<head>
        <link rel="stylesheet" type="text/css" href="website.css">
		<title>The Bishop | Checkmate</title>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
        <h2 id = "usertop" >The Bishop</h2>        
            
        <div class = "piecetutorial" >
            <img class = "knight" src = "bishop.png" alt = "Bishop">          
            <div class = "bishopbox">
                <p>      <br><br>This is the bishop. Each player starts with two, which begin on the row closest to the player, two squares in from each corner.<br /><br />The bishop moves diagonally and has no restrictions in the number of squares it moves. Bishops cannot jump over other pieces.</p>
            </div>
            <div class = "inline">
            <a href="piece_knightmove.php"><input type="imgforback" value="Previous"></a>
             <a href="piece_bishopmove.php"><input type="imgforback" value="Next"></a>
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