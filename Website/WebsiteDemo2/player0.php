<!--	
	session_start();
	if(!session_is_registered(username))
	{
		header("location:login.php");
	}
-->

<html lang="en">

	<head>

		<title>Player0 | Checkmate</title>

	</head>

	<body>

		<header style="text-align:center";>

			<h1><a href="index.php"><img src="logo.png" alt="Checkmate"></h1></a>

		</header>

		<br />

		<section>

			<h1 style="text-align:center;font-size: 60px;"><u>Player0</u></h1>

			<!-- Figure out how to pull from database for username-->

			<br />

			<br />

			<h2 style="float:left;">Player's Statistics </h2>			

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
			<div align = "center">
                <a href="pvp.php"><button type="PVP" style="height: 50px; width: 200px">Player vs Player</button></a>
				<a href="pvai.php"><button type="PVAI" style="height: 50px; width: 200px">Player vs Computer</button></a>
				<a href="tutorial.php"><button type="Tutorial" style="height: 50px; width: 200px">Start Tutorial</button></a>
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

		<br />

		<br />

		<br />

		<br />

		<footer style="float:right;">

			<a href="help.php"><img src="help.png"></a> <a href="contact.php"><img src="contact.png"></a> <a href="options.php"><img src="options.png"></a>

		</footer>

	</body>

</html>