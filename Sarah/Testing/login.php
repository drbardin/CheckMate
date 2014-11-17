<?php

session_start();

if(!(isset($_SESSION["login"]) && $_SESSION["login"] != ""))
{
    ?>

    <!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login | Checkmate</title>
	</head>
	<body>
		<header style="text-align:center";>
			<h1><a href="index.php"><img src="logo.png" alt="Checkmate"></h1></a>
             <link rel="stylesheet" type="text/css" href="website.css">
		</header>
		<br />
		<section>
			<h2 id = "top" >Login</h2>
			<form method="POST" action="validatelogin.php">
			<div class="login">
                <input type="username" name = "username" placeholder="Username" id="username">  
                <input type="password" name = "password" placeholder="Password" id="password">  
                <input type="submit" value="Submit">
            </div>
			</form>
		</section>
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
			<a href="help.php"><img src="help.png"></a> <a href="contact.php"><img src="contact.png"></a><a href="options.php"><img src="options.png"></a>
            </div>                                                                            
		</footer>
	</body>
</html>
    
    <?php
}

else{
    
    header('Location: /player0.php');
}
    ?>

