<?php
    include "classPlayer.php";
    session_start();
?>

<html lang="en">

	<head>

		<title><?php
                $username = $_SESSION["player"]->getUsername();
                echo $username;
            ?> | Checkmate</title>
        
		<style>  
			div.padded {  
				text-align: center;
			}  
		</style>
	</head>

	<body>

		<header style="text-align:center";>

			<h1><a href="index.php"><img src="logo.png" alt="Checkmate"></h1></a>

		</header>

		<br />

		<section>

			<h1 style="text-align:center;font-size: 60px;"><u><?php
                $username = $_SESSION["player"]->getUsername();
                echo $username;?></u></h1>
            
			
			<!-- Figure out how to pull from database for username-->

			<br />

			<br />
			<h2 style="float:left;"><?php
                $username = $_SESSION["player"]->getUsername();
                echo $username;
            ?>'s Statistics </h2>			

			<br />

			<br />

			<br />

			<ul style="float:left;">

				<li>Games Played: 15 </li><br />

				<li>Games Won: 6</li><br />

				<li>Games Lost: 9</li><br />

			</ul>
            
            <br />
            
			<br />
 
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<div class = "padded" >
                <a href="pvp.php"><button type="PVP" style="height: 50px; width: 200px">Player vs Player</button><br /></a><br />
				<a href="pvai.php"><button type="PVAI" style="height: 50px; width: 200px">Player vs Computer</button></a><br /><br />
				<a href="tutorial.php"><button type="Tutorial" style="height: 50px; width: 200px">Start Tutorial</button></a><br />
			</div>
            <br />
            
			<br />

			<br />
		</section>

		<br />

		<br />

		<br />

		<br />

		<br />

		<br />


		<footer style="float:right;">

			<a href="help.php"><img src="help.png"></a> <a href="contact.php"><img src="contact.png"></a> <a href="options.php"><img src="options.png"></a>

		</footer>

	</body>

</html>
