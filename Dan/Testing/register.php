<?php
    session_start();

if(!(isset($_SESSION["login"]) && $_SESSION["login"] != ""))
{
    ?>
    
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Register | Checkmate</title>
        <style type = "text/css">
            .error {color: #FF0000;}
        </style>
        <script>
            function validateForm() {
                var name     = document.forms["validatereg"]["name"].value;
                var email    = document.forms["validatereg"]["email"].value;
                var username = document.forms["validatereg"]["username"].value;
                var password = document.forms["validatereg"]["password"].value;
                if (name ==null || name =="") {
                    alert("Name must be filled out");
                    return false;
                }
                if (email ==null || email =="") {
                    alert("Email must be filled out");
                    return false;
                }
                if (username ==null || username =="") {
                    alert("Username must be filled out");
                    return false;
                }
                if (password ==null || password =="") {
                    alert("Password must be filled out");
                    return false;
                }
            }
        </script>
	</head>
	<body>
        
		<header style="text-align:center";>
			<h1><a href="index.php"><img src="logo.png" alt="Checkmate"></h1></a>
            <link rel="stylesheet" type="text/css" href="website.css">
		</header>
		<section>
			<h2 id = "top">Registration</h2>
            
			<form name = "validatereg" action="newuser.php" onsubmit="return validateForm()" method="post">
                <div class="register">
                    <input type="name" name = "name" placeholder="Name" id="name"> *
                    <input type="username" name = "username" placeholder="Username" id="username"> *  
                    <input type="password" name = "password" placeholder="Password" id="password"> *
                    <input type="email" name = "email" placeholder="Email" id="email"> *
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
		<br />
		<br />
		<footer style="float:right;">
			<a href="help.php"><img src="help.png"></a> <a href="contact.php"><img src="contact.png"></a> <a href="options.php"><img src="options.png"></a>
		</footer>
	</body>
</html>

<?php
}
else{    
    header('Location: /player0.php');
}

?>