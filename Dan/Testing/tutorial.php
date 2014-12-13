<?php
	session_start();
?>
<html lang="en">

	<head>
        <!-- <link rel="stylesheet" type="text/css" href="chessboard.css"> -->
        <link rel="stylesheet" type="text/css" href="board_canvas.css">
		<title>Tutorial | Checkmate</title>

	</head>

	<body id = "tutorialbody">

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>

		<br />

		<br />

		<br />

		<br />
         <div id = "leftcapturedcontainer"><img src = "Container_img.png" alt = "Container img" width: "700" height = "390"> </div>
		<br />
        <div id="container">
            <img class="displayed" src="chessboard_image.png" alt="Chessboard image" width:"800"; height:"800">
            <canvas id="gameCanvas" width="800" height="800"></canvas>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" ></script>
            <script src="http://cdnjs.cloudflare.com/ajax/libs/ocanvas/2.7.3/ocanvas.min.js"></script>
            <script type="text/javascript" src="board.js"></script>
        </div>
        
		<br />
        <div id = "rightcapturedcontainer"><img src = "Container_img.png" alt = "Container img" width: "700" height = "390"> </div>
		<br />

		<br />
        <a href="player0.php"><button type="Player0 Return" style="height: 50px; width: 200px">Return to Dashboard</button><br /></a><br />
		<br />

		<br />

		<br />

		<footer style="float:right;">
            <a href="options.php"><img src="options.png"></a>
		</footer>

	</body>

</html>