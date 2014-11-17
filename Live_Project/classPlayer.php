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

    if (!function_exists('get_Player'))
    {
        function get_Player($accountID)
        {
            // Database info
            $db_host = 'mysql.cs.iastate.edu';
            $db_user = 'u309M13';
            $db_pass = 'T2GWRYDIw';
            $db_name = 'db309M13';
            $tbl_name = 'Account';

            // Create a connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

            // Define a SELECT statement.
            $sql = "SELECT * FROM $tbl_name WHERE id = '$accountID'";

            // Store the result of the query.
            $result = $conn->query($sql);

            // Check if no match was found. Return -1 if no match.
            // Otherwise, store row data and return an instance of the Player class.
            if ($result->num_rows < 1)
            {
                $conn->close();
                return -1;  
            }
            // Otherwise, store row data and return an instance of the Player class.
            else if ($result->num_rows === 1)
            {
                if ($row = $result->fetch_assoc())
                {
                    $player = new Player($row["id"],$row["username"],$row["password"],$row["name"],$row["email"]);
                    $conn->close();
                    return $player;
                }
                else
                {
                    echo "Error: Unable to fetch result.";
                }
            }
            else
            {
                    echo "Error: Too many rows returned.";
            }
            //Close the connection
            $conn->close();
        }
    }
?>