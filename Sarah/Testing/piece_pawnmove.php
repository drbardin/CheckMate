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
        <h2 id = "usertop" >The Pawn's Movement</h2>        
            
        <div class = "chesspawntutorial" >
            <div class = "chesspawnbox">
                <p><br>If it is that pawn's first move, it can either move one space forward, or two.</p>
            </div>
                 <img class = "chessboard" src = "pawnmovement.PNG" alt = "chessboard">
            <br />
            <br />
            <br />
            <div class = "inline">
            <a href="eachpiece_pawn.php"><input type="tutorialforback" value="Previous"></a>
             <a href="pawn_capture.php"><input type="tutorialforback" value="Next"></a>
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