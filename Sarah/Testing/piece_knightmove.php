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
        <script language="javascript">   
            function changeImage(item) {
                if (item.src.split("/").pop() === "bknight_movements.png") 
                {
                    item.src = "wknight_movements.png";
                }
                else 
                {
                    item.src = "bknight_movements.png";
                }
            }
        </script>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
        <h2 id = "usertop" >The Knight's Movement</h2>        
            
        <div class = "chesspawntutorial" >
            <div class = "chesspawnbox">
                <p>  <br>The Knight moves in an L Shape. Click the Knights to see how they can move from their given spot!</p>
            </div>
                 <img class = "chessboard" src = "bknight_movements.png" alt = "chessboard" onclick = "changeImage(this)">
            <br />
            <br />
            <br />
            <div class = "inline">
            <a href="eachpiece_knight.php"><input type="tutorialforback" value="Previous"></a>
             <a href="eachpiece_bishop.php"><input type="tutorialforback" value="Next"></a>
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