<!--	
	session_start();
	if(!session_is_registered(username))
	{
		header("location:login.php");
	}
-->
<html lang="en">

	<head>
        <!-- <link rel="stylesheet" type="text/css" href="chessboard.css"> -->
        <link rel="stylesheet" type="text/css" href="board_canvas.css">
		<title>PVP | Checkmate</title>

	</head>

	<body id = "pvpbody">

		<header style="text-align:center";>
			<h1><a href="index.php"><img src="logo.png" alt="Checkmate"></a></h1>
		</header>

		<br />
        
		<br />

		<br />
        <div id = "leftcapturedcontainer"><img src = "Container_img.png" alt = "Container img" width: "700" height = "390"> </div>
		<br />
        
		<br />
        <div id="container">
            <img class="displayed" src="chessboard_image.png" alt="Chessboard image" width:"800"; height:"800">
            <canvas id="gameCanvas" width="800" height="800"></canvas>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" ></script>
            <script type="text/javascript" src="board.js"></script>
        </div>
        <div id = "rightcapturedcontainer"><img src = "Container_img.png" alt = "Container img" width: "700" height = "390"> </div>
		<br />
        
		<br />

		<br />
        <a href="player0.php"><button type="Player0 Return" style="height: 50px; width: 200px">Return to Dashboard</button><br /></a><br />
		<br />

		<br />

		<br />

		<footer style="float:right;">

			<a href="help.php"><img src="help.png"></a> <a href="http://corgiorgy.com"><img src="contact.png"></a> <a href="options.php"><img src="options.png"></a>

		</footer>

	</body>

</html>