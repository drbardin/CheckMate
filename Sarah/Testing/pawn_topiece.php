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

                if (document.getElementById("imgClickAndChange").src = "pawn_promote.png") 
                {
                    document.getElementById("imgClickAndChange").src = "pawn_queen.png";
                }
                else 
                {
                    document.getElementById("imgClickAndChange").src = "pawn_promote.png";
                }
            }
        </script>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
        <h2 id = "usertop" >Promote a Pawn</h2>        
            
        <div class = "chesspawntutorial" >
            <div class = "chesspawnbox">
                <p><br>If the pawn makes it to the other side of the board, you can choose to turn it into any other piece. Click the black pawn to turn it into a queen!</p>
            </div>
                 <img class = "chessboard" id = "imgClickAndChange"  src = "pawn_promote.png" alt = "chessboard" onclick = "changeImage()">
            <br />
            <br />
            <br />
            <div class = "inline">
                <a href="pawn_capture.php"><input type="tutorialforback" value="Previous"></a>
                <a href="eachpiece_rook.php"><input type="tutorialforback" value="Next"></a>
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