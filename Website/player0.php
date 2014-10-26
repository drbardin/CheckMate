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

			<h1 style="text-align:center;font-size: 60px;">
                <u>
                    <?php
                          $player = $_SESSION[player];
                          print $player->get($username);
                    ?>
                </u>
            </h1>

			<!-- Figure out how to pull from database for username-->

			<br />

			<br />

			<h2 style="float:left;">Player's Statistics </h2>			

			<br />

			<br />

			<br />

			<ul style="float:left;">
                <?php
                    $con = mysqli_connect(
                ?>
				<li>Games Played: <?php
                          $player = $_SESSION[player];
                          print $player->get($username);
                    ?></li><br />

				<li>Games Won: <?php
                          $player = $_SESSION[player];
                          print $player->get($username);
                    ?></li><br />

				<li>Games Lost: <?php
                          $player = $_SESSION[player];
                          print $player->get($username);
                    ?></li><br />

			</ul>
            
            <br />
            
			<br />

			<br />
                <a href="pvp.php"><button type="PVP" style="height: 50px; width: 200px">PVP</button></a>
            <br />
            
			<br />

			<br />
		</section>

		<br />

		<br />

		<br />

		<br />

		<br />

		<!--a href="index.php"><button type="home"><<< Home (REMOVE THIS LATER, YO)</button></a -->

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