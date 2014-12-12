<?php
    include "classPlayer.php";
    session_start();

if($_SESSION["login"])
{
    
    ?>

<html lang="en">

	<head>
        <link rel="stylesheet" type="text/css" href="website.css">
		<title>The Knight | Checkmate</title>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
        <h2 id = "usertop" >The Knight</h2>        
            
        <div class = "piecetutorial" >
            <img class = "knight" src = "knight.png" alt = "Knight">          
            <div class = "knightbox">
                <p>     <br><br>This is the knight. Each player starts with two, which begin on the row closest to the player, one square from each corner.<br /><br />The knight's move is unusual; When it moves, it can move to a square that is two squares horizontally and one square vertically, or two squares vertically and one square horizontally. The complete move looks like the letter 'L'.<br /><br />Unlike all other standard chess pieces, the knight can 'jump over' all other pieces (of either color) to its destination square. Click next to see exactly how this works.</p>
            </div>
            <div class = "inline">
            <a href="piece_rookmove.php"><input type="imgforback" value="Previous"></a>
             <a href="piece_knightmove.php"><input type="imgforback" value="Next"></a>
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