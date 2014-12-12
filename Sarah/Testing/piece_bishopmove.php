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
        <script language="javascript">   
            var timer; 

            function changeImage(item) {
                if (timer) clearTimeout(timer);
                timer = setTimeout(function() {
                    if (item.src.split("/").pop() === "wbishop_movements.png") 
                    {
                        item.src = "bbishop_movements.png";
                    }
                    else 
                    {
                        item.src = "wbishop_movements.png";
                    }
                }, 250); 
            }
                        
            function changeDblImage(item) {
                clearTimeout(timer);
                item.src = "bbishop_movements_captured.png";
            }
            
        </script>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
        <h2 id = "usertop" >The Bishop's Movement</h2>        
            
        <div class = "chesspawntutorial" >
            <div class = "chessbishopbox">
                <p>  <br>The Bishop moves diagonally and is only limited by other pieces and the edge of the board. I think you know the drill. Click the bishops! Or double click the pawn to capture it!</p>
            </div>
                 <img class = "chessboard" src = "wbishop_movements.png" alt = "chessboard" onclick = "changeImage(this)" ondblclick="changeDblImage(this)">
            <br />
            <br />
            <br />
            <div class = "inline">
            <a href="eachpiece_bishop.php"><input type="tutorialforback" value="Previous"></a>
             <a href="eachpiece_queen.php"><input type="tutorialforback" value="Next"></a>
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