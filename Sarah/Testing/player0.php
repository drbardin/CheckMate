<?php
    include "classPlayer.php";
    session_start();

if($_SESSION["login"])
{
    
    ?>

<html lang="en">

	<head>
		<title><?php
                $username = $_SESSION["player"]->get_Username();
                echo $username;
            ?> | Checkmate</title>
	</head>

	<body class = "userpage">
        <div id = "loading"></div>
		<header style="text-align:center";>
            <link rel="stylesheet" type="text/css" href="website.css">
			<h1><img src="logo.png" alt="Checkmate"></h1>
		</header>
		<section>
			<h1 style="text-align:center; font-size: 60px;">Welcome, <?php
                $username = $_SESSION["player"]->get_Username();
                echo $username;?>!</h1>
			
            <!-- Statistics code here
			<h2 style="float:left;"><?php
                $username = $_SESSION["player"]->get_Username();
                echo $username;
            ?>'s Statistics </h2>			
			<ul style="float:left;">
				<li>Games Played: 15 </li><br />
				<li>Games Won: 6</li><br />
				<li>Games Lost: 9</li><br />
			</ul>
            -->
            
			<h2 id = "usertop" >Choose a Chess mode:</h2>
			<div class = "useropt" >
                <div class = "buttonwrap">
                    <div id = "submit">
                        <a href="pre_pvp.php"><input type="user" value="Challenge another player" onclick = "ButtonClicked()"></a>
                    </div>
                    <div id = "buttonreplacement" style = "display:none;"><img id="loading-image" src="ajax-loader.gif" alt="Loading..." /></div>
                            <p class = "buttondescription">This chess mode will match you with another player</p>
                </div>
                <div class = "buttonwrap">
                    <a href = "pvai.php"><input type="user" value="Challenge the computer"></a>
                        <p class = "buttondescription">This chess mode will create a match with the computer</p>
                </div>
                <div class = "buttonwrap">
                    <a href="tutorial.php"><input type="user" value="Start Tutorial"></a>
                        <p class = "buttondescription">This chess mode will bring you to the Chess tutorial</p>
                </div>
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
        <script type="text/javascript">
           function ButtonClicked()
            {
               document.getElementById("submit").style.display = "none"; // to undisplay   
               document.getElementById("buttonreplacement").style.display = ""; // to display
               return true;
            }
            var FirstLoading = true;
            function RestoreSubmitButton()
            {
               if( FirstLoading )
               {
                  FirstLoading = false;
                  return;
               }
               document.getElementById("submit").style.display = ""; // to display
               document.getElementById("buttonreplacement").style.display = "none"; // to undisplay
            }
            // To disable restoring submit button, disable or delete next line.
            //document.onfocus = RestoreSubmitButton;
        </script>

		<footer>
            <div class = "footerbuttons">
                <a href="help.php"><img src="help.png"></a> <a href="contact.php"><img src="contact.png"></a> <a href="options.php"><img src="options.png"></a>
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