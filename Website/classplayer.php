<?php
/* Define class Player */
	class Player
	{ 	
		// Intention is that the following values can be accessed via PHP's
		// __get() method.
		private $id;
		private $username;
		private $password;
		private $name;
		private $email;

		public function __construct($id, $username, $password, $name, $email)
		{
			this->$id=$id;
			this->$username=$username;
			this->$password=$password;
			this->$name=$name;
			this->$email=$email;
		}
	}
?>