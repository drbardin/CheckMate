<?php
    include "classPlayer.php";
    include "classGame.php";
    session_start()
?>

<?php

    class Lobby
    {
        private $player_id;
        private $time_entered;
        
        /* 
            Default Constructor:
                Sets variable values based upon SESSION variables and PHP's date() function. 
        */
        public function __construct()
        {
            $this->player_id = $_SESSION["player"]->get_Id();
            $this->time_entered = date('Y-m-d G:i:s');
        }
        
        /*
            Overloaded Constructor:
                Sets variable values based upon parameter input.
            
            NOTE: ERROR-CHECKING NOT YET IMPLEMENTED
        */
        public function __construct($id, $time)
        {
            $this->player_id = $id;
            $this->time_entered = $time;
        }
        
        /*
            Getter for player_id:
                Returns int player_id
        */
        public function get_Player_Id()
        {
             if (isset($this->player_id))
            {
                  return $this->player_id;
            }
            else 
            {
                echo "this->player_id not set.";
            }           
        }
        
        /*
            Getter for time_entered:
                Returns timestamp time_entered
        */
        public function get_Time_Entered()
        {
             if (isset($this->time_entered))
            {
                  return $this->time_entered;
            }
            else 
            {
                echo "this->time_entered not set.";
            }           
        }
        /*
            Get oldest row entry from Lobby table:
                Returns -1 if Lobby table is empty.
                Returns instance of a Lobby class object containing the oldest row contents from the Lobby table.
        */
        public function get_Oldest_Entry()
        {
            // Database info
            $db_host = 'mysql.cs.iastate.edu';
            $db_user = 'u309M13';
            $db_pass = 'T2GWRYDIw';
            $db_name = 'db309M13';
            $tbl_name = 'Lobby';
            
            // Create connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
            
            // Define SELECT statement.
            $sql = "SELECT * FROM $tbl_name WHERE time_entered = MIN(time_entered) LIMIT 1";
            // Store result. 
            $result = $conn->query($sql);
            
            // Check if Lobby table is empty.
            // Otherwise, store row data and return an instance of the Lobby class. 
            if ($result->num_rows < 1)
            {
                $conn->close;
                return -1;
            }
            else if ($result->num_rows === 1)
            {
                if ($row = $result->fetch_assoc())
                {
                    $lobby = new Lobby($row["player_id"],$row["time_entered"]);
                    
                    // Returns an instance of the Lobby class
                    $conn->close;
                    return $lobby;
                }
            }
            else 
            {
                echo "Error: Too many rows returned."
            }
            
            // Close database connection. 
            $conn->close();
        }
        
        /*
            Add current Lobby object contents to Lobby table.
                No return value.
        */
        public function add_To_Table()
        {
            // Database info
            $db_host = 'mysql.cs.iastate.edu';
            $db_user = 'u309M13';
            $db_pass = 'T2GWRYDIw';
            $db_name = 'db309M13';
            $tbl_name = 'Lobby';
            
            // Create connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
            
            // Define INSERT statement.
            $sql = "INSERT INTO $tbl_name (player_id, time_entered)                             VALUES ('$this->player_id', '$this->time_entered')";
            
            // Query the database with our statement. 
            if ($conn->query($sql) === TRUE) 
            {
                echo "Player successfully added to Lobby.";
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            // Close database connection. 
            $conn->close();
        }
        
        public function create_Game($id_first, $id_second)
        {
            
        }
        
        /*
            Deletes specified player from Lobby table.
                No return value.
        */
        public function remove_Player($id)
        {
            // Database info
            $db_host = 'mysql.cs.iastate.edu';
            $db_user = 'u309M13';
            $db_pass = 'T2GWRYDIw';
            $db_name = 'db309M13';
            $tbl_name = 'Lobby';
            
            // Create connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
            
            // Define DELETE statement.
            $sql = "DELETE FROM $tbl_name WHERE player_id = $id";
            
            // Query the database with our statement. 
            if ($conn->query($sql) === TRUE) 
            {
                echo "Player successfully removed from Lobby.";
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            // Close database connection. 
            $conn->close();
        }
        }
        public function add_Player()
        {
            
        }