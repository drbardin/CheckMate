<?php

	class Player
	{ 	
		// Intention is that the following values can be accessed via PHP's
		// __get() method.
		private  $id;
		private  $username;
		private  $password;
		private  $name;
		private  $email;

		public function __construct($accountID, $accountUsername, $accountPassword, $accountName, $accountEmail)
		{
			$this->id=$accountID;
			$this->username=$accountUsername;
			$this->password=$accountPassword;
			$this->name=$accountName;
			$this->email=$accountEmail;
		}
        
        public function get_Id()
        {
            if (isset($this->id))
            {
                  return $this->id;
            }
            else 
            {
                echo "id not set.";
            }
            
        }
        public function get_Username()
        {
            if (isset($this->username))
            {
                  return $this->username;
            }
            else 
            {
                echo "username not set.";
            }
            
        }
        public function get_Password()
        {
            if (isset($this->password))
            {
                  return $this->password;
            }
            else 
            {
                echo "password not set.";
            }
        }
        public function get_Name()
        {
            if (isset($this->name))
            {
                  return $this->name;
            }
            else 
            {
                echo "name not set.";
            }
        }
        public function get_Email()
        {
            if (isset($this->email))
            {
                  return $this->email;
            }
            else 
            {
                echo "email not set.";
            }
        }
	}

    function __autoload($class_name) {
        include 'class' . $class_name . '.php';
    }
?>