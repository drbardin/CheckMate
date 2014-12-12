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
        <script language="javascript">   
            function changeImage(item) {
                if (item.src.split("/").pop() === "wking_movement.png") 
                {
                    item.src = "bking_movement.png";
                }
                else 
                {
                    item.src = "wking_movement.png";
                }
            }
        </script>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
        <h2 id = "usertop" >The King's Movement</h2>        
            
        <div class = "chesspawntutorial" >
            <div class = "chessqueenbox">
                <p><br>The King can move only one space in any direction. Sigh. Click the Kings to see how much they fail.</p>
            </div>
                 <img class = "chessboard" src = "wking_movement.png" alt = "chessboard" onclick = "changeImage(this)">
            <br />
            <br />
            <br />
            <div class = "inline">
            <a href="eachpiece_king.php"><input type="tutorialforback" value="Previous"></a>
             <a href="piece_finished.php"><input type="tutorialforback" value="Next"></a>
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