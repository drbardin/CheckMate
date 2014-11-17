<?php
    include "classPlayer.php";
    include "classGame.php";
    session_start()
?>

<?php

    $db_host = 'mysql.cs.iastate.edu';
    $db_user = 'u309M13';
    $db_pass = 'T2GWRYDIw';
    $db_name = 'db309M13';

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
            // $this->time_entered = date('Y-m-d G:i:s');
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
            $tbl_name = 'Lobby';
            
            // Create connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
            
            // Define INSERT statement.
            $sql = "INSERT INTO $tbl_name (player_id, time_entered) VALUES ('$this->player_id', '$this->time_entered')";
            
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
          
        /*
            Deletes specified player from Lobby table.
                No return value.
        */
        public function remove_Player($id)
        {
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
        
        /*
            Creates an entry in the Game table. Removes both players from the Lobby.
                No return value.
        */
        public function create_Game($id_first, $id_second)
        {
            $tbl_name = 'Game';
            
            //Parameter error checking
            if ($id_first === $id_second)
            {
                // Throw error, id parameters must be different. 
                echo "create_Game() Error: Paramters are identical. Must have two different account ids to create a game."; 
            }
            // Check for matching account on first id.
            $white = get_Player($id_first);
            if ($white === -1)
            {
                // Throw error, first parameter is not a valid account id.
                echo "create_Game() Error: First parameter is not a valid account id.";
            }
            // Check for matching account on second id. 
            $black = get_Player($id_second);
            if ($black === -1)
            {
                // Throw error, second parameter is not a valid account id.
                echo "create_Game() Error: First parameter is not a valid account id.";
            }

            // Create connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
            
            // Define INSERT statement.
            $sql = "INSERT INTO $tbl_name (white_id, black_id, turn_num, white_in, black_in, white_username, black_username, board_json) VALUES ("$white->get_Id()", "$black->get_Id()", "0", "0","0","$white->get_Username()", "$black->get_Username()")";
            
            // Query the database with our statement. 
            if ($conn->query($sql) === TRUE) 
            {
                echo "Game successfully created.";
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            // Close database connection. 
            $conn->close();
            
            // Remove both players from the lobby.
            remove_Player($first_id);
            remove_Player($second_id);
        }
        
        
        /*
            Attempts to add the player to the Lobby, but first checks if theres an person waiting in the lobby.
            Will create a game if opponent is found. Otherwise, adds player to lobby.
                No return value.
        */
        public function add_Player()
        {
            $tbl_name = 'Lobby';

            $opponent = $this->get_Oldest_Entry();
            
            if ($opponent === -1)
            {
                echo "No opponent found.";
                $this->time_entered = date('Y-m-d G:i:s');
                $this->add_To_Table();
            }
            else
            {
                echo "Opponent found. Create game.";
                $this->create_Game($opponent->get_Player_Id(),$this->player_Id);
            }
        }
    };
?>