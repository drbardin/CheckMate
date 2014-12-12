<?php
    include "classPlayer.php";
    session_start();

if($_SESSION["login"])
{
    
    ?>

<html lang="en">

	<head>
        <link rel="stylesheet" type="text/css" href="website.css">
		<title>Choose a Tutorial | Checkmate</title>
	</head>

	<body class = "tutorialbody" >

		<header style="text-align:center";>
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
		<br />
        <h2 id = "usertop" >Choose a Tutorial!</h2>
        
            <h2 id = "subtop" >More tutorials will unlock as you play.</h2>
        <div class = "usertutorial" >
                <div class = "buttonwrap">
                    <div id = "submit">
                        <a href="eachpiece_pawn.php"><input type="tutorialpage" value="Introduction to Chess" onclick = "ButtonClicked()"></a>
                    </div>
                    <div id = "buttonreplacement" style = "display:none;"><img id="loading-image" src="ajax-loader.gif" alt="Loading..." /></div>
                        <p class = "buttondescription_tutorial">Introduction to each piece</p>
                </div>
                <div class = "buttonwrap">
                    <a href = "pvai.php"><input type="tutorialpage" value="How to Play"></a>
                        <p class = "buttondescription_tutorial">Introduction to the Rules</p>
                </div>
                <div class = "buttonwrap">
                    <a href="tutorial.php"><input type="tutorialpage" value="The Next Step"></a>
                        <p class = "buttondescription_tutorial">Begin playing against the computer</p>
                </div>
        </div>
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