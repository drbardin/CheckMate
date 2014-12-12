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
        <script language="javascript">   
            function changeImage(item) {
                if (item.src.split("/").pop() === "rook_move_white.png") 
                {
                    item.src = "rook_move_black.png";
                }
                else 
                {
                    item.src = "rook_move_white.png";
                }
            }
        </script>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
        <h2 id = "usertop" >The Rook's Movement</h2>        
            
        <div class = "chesspawntutorial" >
            <div class = "chesspawnbox">
                <p><br>The rook can move horizontally or vertically, through any number of unoccupied squares. Click the black or white rook to see how they move on the board.</p>
            </div>
                 <img class = "chessboard" src = "rook_move_white.png" alt = "chessboard" onclick = "changeImage(this)">
            <br />
            <br />
            <br />
            <div class = "inline">
            <a href="eachpiece_rook.php"><input type="tutorialforback" value="Previous"></a>
             <a href="eachpiece_knight.php"><input type="tutorialforback" value="Next"></a>
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