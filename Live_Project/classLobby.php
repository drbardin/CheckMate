<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
include_once "classPlayer.php";
session_start();
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
/*        public function __construct()
        {
            $this->player_id = $_SESSION["player"]->get_Id();
            // $this->time_entered = date('Y-m-d G:i:s');
        }*/
        
        function __construct()
        {
            $args = func_get_args();
            $num_args = func_num_args();
            if (method_exists($this, $f='__construct'.$num_args))
            {
                call_user_func_array(array($this,$f),$args);   
            }
            else
            {
                $this->player_id = $_SESSION["player"]->get_Id();
            }
            
        }
        
        /*
            Overloaded Constructor:
                Sets variable values based upon parameter input.
            
            NOTE: ERROR-CHECKING NOT YET IMPLEMENTED
        */
        public function __construct2($id, $time)
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
             $db_host = 'localhost';
            $db_user = 'root';
            $db_pass = 'root';
            $db_name = 'db309M13';
            $db_port  = 8889;
            $tbl_name = 'Lobby';
            
            // Create connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
            
            // Define SELECT statement.
            $sql = "SELECT * FROM $tbl_name ORDER BY time_entered ASC LIMIT 1";
            // Store result. 
            $result = $conn->query($sql);
            
            // Check if Lobby table is empty.
            // Otherwise, store row data and return an instance of the Lobby class. 
            if ($result->num_rows < 1)
            {
                echo "get_Oldest_Entry(): Less than 1 row in result" . "<br/>";
                $conn->close();
                return -1;
            }
            else if ($result->num_rows === 1)
            {
                if ($row = $result->fetch_assoc())
                {
                    $lobby = new Lobby($row["player_id"],$row["time_entered"]);
                    
                    // Returns an instance of the Lobby class
                    $conn->close();
                    return $lobby;
                }
            }
            else 
            {
                echo "Error: Too many rows returned" . "<br/>";
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
             $db_host = 'localhost';
            $db_user = 'root';
            $db_pass = 'root';
            $db_name = 'db309M13';
            $db_port  = 8889;
            $tbl_name = 'Lobby';
            
            // Create connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
            
            $pId = $this->player_id;
            $timeEnt = $this->time_entered;
            
            // Define INSERT statement.
            $sql = "INSERT INTO Lobby (player_id, time_entered) VALUES ('$pId','$timeEnt')";
            
            // Query the database with our statement. 
            if ($conn->query($sql) === TRUE) 
            {
                echo "Player successfully added to Lobby." . "<br/>";
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            // Close database connection. 
            $conn->close();
        }
          
        
        
        /*
            Deletes specified player from Lobby table.
                No return value.
        */
        public function remove_Player($id)
        {
             $db_host = 'localhost';
            $db_user = 'root';
            $db_pass = 'root';
            $db_name = 'db309M13';
            $db_port  = 8889;
            $tbl_name = 'Lobby';
            
            // Create connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
            
            // Define DELETE statement.
            $sql = "DELETE FROM $tbl_name WHERE player_id = $id";
            
            // Query the database with our statement. 
            if ($conn->query($sql) === TRUE) 
            {
                echo "Player successfully removed from Lobby." . "<br/>";
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            // Close database connection. 
            $conn->close();
        }
        
        
        
        
        
        /*
            Creates an entry in the Game table. Removes both players from the Lobby.
                No return value.
        */
        public function create_Game($id_first, $id_second)
        {
             $db_host = 'localhost';
            $db_user = 'root';
            $db_pass = 'root';
            $db_name = 'db309M13';
            $db_port  = 8889;
            $tbl_name = 'Game';
            
            //Parameter error checking
            if ($id_first === $id_second)
            {
                // Throw error, id parameters must be different. 
                echo "create_Game() Error: Paramters are identical. Must have two different account ids to create a game." . "<br/>";
                return;
            }
            // Check for matching account on first id.
            $white = get_Player($id_first);
            if ($white === -1)
            {
                // Throw error, first parameter is not a valid account id.
                echo "create_Game() Error: First parameter is not a valid account id." . "<br/>";
                return;
            }
 
            // Check for matching account on second id. 
            $black = get_Player($id_second);
            if ($black === -1)
            {
                // Throw error, second parameter is not a valid account id.
                echo "create_Game() Error: First parameter is not a valid account id." . "<br/>";
                return;
            }

            // Create connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
            
            $wId = $white->get_Id();
            $bId = $black->get_Id();
            $wUsername = $white->get_Username();
            $bUsername = $black->get_Username();
            
            // Define INSERT statement.
            $sql = "INSERT INTO $tbl_name (white_id, black_id, turn_num, white_in, black_in, white_username, black_username) VALUES ('$wId', '$bId', 0, 0, 0,'$wUsername', '$bUsername')";
            
            // Query the database with our statement. 
            if ($conn->query($sql) === TRUE) 
            {
                echo "Game successfully created." . "<br/>";
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            // Close database connection. 
            $conn->close();
            
            // Remove both players from the lobby.
            $this->remove_Player($id_first);
            $this->remove_Player($id_second);
        }
        
        
        
        
        /*
            Attempts to add the player to the Lobby, but first checks if theres an person waiting in the lobby.
            Will create a game if opponent is found. Otherwise, adds player to lobby.
                No return value.
        */
        public function add_Player()
        {
             $db_host = 'localhost';
            $db_user = 'root';
            $db_pass = 'root';
            $db_name = 'db309M13';
            $db_port  = 8889;
            $tbl_name = 'Game';

            //NEED A CHECK HERE TO MAKE SURE THAT THE CURRENT ID ISN'T ALREADY IN A GAME.
            //Create connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

            // Check connection
            if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
            }

            
            $sql      = "SELECT * FROM $tbl_name WHERE '$this->player_id' = white_id OR '$this->player_id' = black_id";
            $result   = $conn->query($sql);

            // If result matched $username and $password, table row must be 1 row
            if ($result->num_rows > 0)
            {
                echo "This player is already in a Game." . "<br/>";
                $conn->close();
                return;
            }
            else
            {
                $conn->close();
                $opponent = $this->get_Oldest_Entry();
    
                if ($opponent === -1)
                {
                    echo "No opponent found." . "<br/>";
                    $this->time_entered = date("Y-m-d H:i:s", time());
                    $this->add_To_Table();
                }
                else
                {
                    echo "Opponent found. Create game." . "<br/>";
                    $this->create_Game($opponent->get_Player_Id(),$this->player_id);
                }
            }
        }
    }
?>