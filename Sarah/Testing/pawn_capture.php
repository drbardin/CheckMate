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
        <script language="javascript">
            function changeImage() {

                if (document.getElementById("imgClickAndChange").src = "pawncapture.png") 
                {
                    document.getElementById("imgClickAndChange").src = "captured_pawn.png";
                }
                else 
                {
                    document.getElementById("imgClickAndChange").src = "pawncapture.png";
                }
            }
        </script>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
        <h2 id = "usertop" >Capturing with a Pawn</h2>        
            
        <div class = "chesspawntutorial" >
            <div class = "chesspawnbox">
                <p><br>The pawn must move diagonally to capture a piece. Here, the white pawn can capture the black pawn. Click on the black pawn to capture it!</p>
            </div>
                 <img class = "chessboard" id = "imgClickAndChange"  src = "pawncapture.PNG" alt = "chessboard" onclick = "changeImage()">
            <br />
            <br />
            <br />
            <div class = "inline">
            <a href="piece_pawnmove.php"><input type="tutorialforback" value="Previous"></a>
             <a href="pawn_topiece.php"><input type="tutorialforback" value="Next"></a>
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