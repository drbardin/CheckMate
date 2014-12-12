<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
include_once "classPlayer.php";
include_once "classGame.php";
session_start();
?>
<?php
    class Piece 
    {
        $db_host = 'mysql.cs.iastate.edu';
        $db_user = 'u309M13';
        $db_pass = 'T2GWRYDIw';
        $db_name = 'db309M13';
        
		$id;
		$enumeration;
		$row;
		$col;
		
		$color;
        $game_id;

        //in this case, row, col, and id are all in respect to the target
		//$potential_moves = array("to"=>array(array("row"=>,"col"=>,"id"=>)));
        $potential_moves = array(array());

            function __construct($piece_row, $piece_col) {
                
                // Create connection
                $conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
                $client_id = $_SESSION["player"].get_Id();
                //---------------------------------------------------------------------------------
                // Get game_id
                $sql0 = "SELECT game_id 
                         FROM Game 
                            WHERE white_id = '$client_id' 
                            OR black_id = '$client_id'";
                $result0 = conn->query($sql0);
                
                if ($result0->num_rows === 1)
                {
                    $this->game_id = $row["game_id"];
                }
                else {echo "Incorrect # of rows returned whilst querying for the game_id." . $E_USER_ERROR;}
                //---------------------------------------------------------------------------------
                $sql1 = "SELECT enumeration, occupier_id 
                         FROM Square 
                            WHERE row = '$piece_row' 
                            AND col = '$piece_col' 
                            AND game_id = '$this->game_id'";
                $result1 = $conn->query($sql1);
                    
                if ($result1->num_rows === 1) 
                {
                    $row = $result1->fetch_association();
                    $this->id=$row["occupier_id"];
                    if (($this->id < 200) and ($this->id >= 100))
                    {
                        $this->color = 'b';
                    }
                    else if ($this->id >=200)
                    {
                        $this->color = 'w';
                    }
                    else { /*This should be an error. Not a valid id*/ }
                    $this->enumeration=$row["enumeration"];
                    $this->row=$piece_row;
                    $this->col=$piece_col;
                }
                else {/*This should throw an error! At least/Only one row expected in the result*/}
                //--------------------------------------------------------------------------------------
                $sql2 = "SELECT * 
                         FROM Moves
                         WHERE piece_id = '$this->id' 
                         AND game_id = '$this->game_id'";
                $result2 = $conn->query($sql2);
                while ($row = $result2->fetch_association())
                {
                        $temp = array("row"=>$row["to_row"],"col"=>$row["to_col"],"id"=>$row["target_id"]);
                        $this->potential_moves["to"].push($temp);
                }
                $conn->close();
			}
 
			public function get_Piece_Id(){
                return $this->id;
            }
			public function get_Enum(){
                return $this->enum;
            }
			public function get_Row(){
                return $this->row;
            }
			public function get_Col(){
                return $this->col;
            }
            public function get_Color(){
                return $this->color;
            }
			public function get_Potential_Moves(){
                return $this->potential_moves;
            }
            private function set_Moves()
            {
                // Create connection
                $conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
                
                for ($i = 0; $i < $this->potential_moves->length;$i++)
                {
                    $sql = "INSERT INTO Moves (game_id, piece_id, to_row, to_col, from_row, from_col) 
                            VALUES ('$this->game_id', '$this->id,'$this->potential_moves["to"][$i]["row"]','$this->potential_moves["to"][$i]["row"]','$this->row','$this->col')";
                    $conn->query($sql);
                    $conn->close();
                }
            }
            // Potential Moves for this piece will need to be re-evaluated.
            private function update_Tables($row, $col, $target_enum, $occupier_id) 
            {
                $isEmpty = true;
                // Create connection
                $conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
                
                clear_Moves();
                // If taking a piece, Update 0pponent's Piece.
                if ($occupier_id != 0)
                {
                    isEmpty = false;
                    $sql0 = "UPDATE Piece
                             SET row = -1
                                 col = -1
                            WHERE piece_id = '$occupier_id'
                            AND game_id = '$this->game_id'";
                    $conn->query($sql0);
                }
                //Update My Piece
                $sql1 = "UPDATE Piece
                         SET row = '$row'
                         AND col = '$col'
                         WHERE piece_id = '$this->id'
                         AND game_id = '$this->game_id'";
                $conn->query($sql1);
                
                //Update New Square 
                $sql2 = "UPDATE Square 
                        SET enumeration = '$this->enumeration',
                            occupier_id = '$this->id'
                        WHERE row = '$row'
                        AND col = '$col'
                        AND game_id = '$this->game_id'";
                $conn->query($sql2);
                
                //Update Old Square
                $empty_enum = -1;
                $sql3 = "UPDATE Square
                         SET enumeration = '$empty_enum',
                             occupier_id = '0'
                        WHERE row = '$this->row'
                        AND col = '$this->col'
                        AND game_id = '$this->game_id'";
                $conn->query($sql3);
                $conn->close();
                
                $game = new Game;
                $board_rep = $game->get_Board_Representation();
                $board_rep = unserialize($board_rep);
                //$old_piece;
                if (!$isEmpty) {
                     // $old_piece = array("piece"=>$target_enumeration, "row"=>-1, "col"=>-1, "status"=>false, "id"=>$occupier_id);
                }
                $empty_square = array("piece"=>-1, "row"=>$row, "col"=>$col, "status"=>true, "id"=>0);
                $old_index = ($this->row * 7) + $this->row + $this->col;
                $new_index = ($row * 7) + $row + $col;
                $new_piece = array("piece"=>$this->enumeration, "row"=>$row, "col"=>$col, "status"=>true, "id"=>$this->id);
                $board_rep["board"][$old_index] = $empty_square;
                $board_rep["board"][$new_index] = $new_piece;
                $board_rep = serialize($board_rep);
                $game->set_Board_Representation($board_rep);
                $game->update_Game();
            }      
            private function clear_Moves()
            {
                // For each occurance of piece_id = $id, game_id = $game_id
                
                // Create connection
                $conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
                $sql = "DELETE * 
                        FROM Moves 
                        WHERE piece_id = '$this->id' 
                        AND game_id = '$this->game_id'";
                $conn->query($sql);
                $conn->close();
            }
            public function move_Piece($to_row,$to_col)
            {
                
                // Create connection
                $conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
                //Don't do what Dan has already done.
        
                //First: Check if ($id, $to_row, $to_col, $game_id) in SELECT '
                ////////////////////////////////////////////
                // First: Check if target square is a piece.
                    // If value != 0, then is a piece. Else is empty.
                $sql1 = "SELECT occupier_id 
                         FROM Square 
                         WHERE to_row ='$to_row'
                         AND to_col = '$to_col'
                         AND game_id = '$this->game_id'";
                $result1 = $conn->query($sql);
                $row1 = $result1->fetch_association();
                $conn->close();
                $this->update_Tables($to_row, $to_col, $this->enumeration, $row1);
            }
        private function set_Potential_Moves($moves_arr)
        {
            $this->potential_moves = $moves_arr;
            $this->set_Moves();
        }
    }
/*// These functions need to belong to a different class. Perhaps Game or Lobby?
			public function clear_Tables() {
				// Important: Do in this order:
					// Clear all pieces w/ this $game_id from Moves Table
					// Clear all pieces w/ this $game_id from Piece Table.
					// Clear all pieces w/ this $game_id from Square Table.
					// Change isset to false.
			}
			public function init_Set_Squares(){
				// If isset true, don't continue.
					//
                $is_set_squares;
		        $is_set_pieces;
		        $is_set_moves;
			}
            public function get_Enum_Square($row, $col)
            {
                
            }*/
?>