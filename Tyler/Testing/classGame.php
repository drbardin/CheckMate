<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include_once "classPlayer.php";
//include_once "engine.php";
session_start();
?>

<?php
// game object definition
class Game {
    
// Game Table Values
    // This player's game id.
    private $game_id;
    // This player's client id. 
    private $client_id;
    // Each color's player id.
    private $white_id;
    private $black_id;
    // The username associated with each color.
    private $white_username;
    private $black_username;
    // Denotes whether that colored player is currently on the game screen.
    private $white_in;
    private $black_in;
    // Current turn number.
    private $turn_num;
    // 2D Array containing black_pieces and white_pieces. Is to be encoded to client as a JSON
    private $board_rep = array(array());
    
// Calculateable Values
    // Color-specific array that is ready to be encoded to client as a JSON. (A subset of $board_rep)
    private $black_pieces;
    private $white_pieces;
    // Denotes the color of the player whose turn it is.  (Dictated by whether the $turn_num is even or odd)
    private $cur_color; //either "w" or "b"
    
// Session_Specific Values
    // Denotes the color that is associated with 
    private $my_color; // either "w" or "b"
    // Tells whether or not it is this client's turn.
    private $clients_turn = FALSE; // either true or false
    private $potential_moves = array();
    
    // Default constructor
    function __construct()
    {
        $this->client_id = $_SESSION["player"]->get_Id();
        
        $db_host = 'mysql.cs.iastate.edu';
        $db_user = 'u309M13';
        $db_pass = 'T2GWRYDIw';
        $db_name = 'db309M13';
        $tbl_name = 'Game';

        //Create connection
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql      = "SELECT * FROM $tbl_name WHERE white_id = '$this->client_id' OR black_id = '$this->client_id'";
        $result   = $conn->query($sql);

        // If result matched $username and $password, table row must be 1 row
        if ($result->num_rows === 1)
        {
            if ($row = $result->fetch_assoc())
            {
                $this->game_id = $row["game_id"];
                $this->white_id = $row["white_id"];
                $this->black_id = $row["black_id"];
                $this->turn_num = $row["turn_num"];
                $this->white_in = $row["white_in"];
                $this->black_in = $row["black_in"];
                $this->white_username = $row["white_username"];
                $this->black_username = $row["black_username"];
                $this->board_rep = $row["board_json"];
                
 //              $this->cur_color = $row["cur_color"];
 //              $this->black_json = $row["black_json"];
 //              $this->white_json = $row["white_json"];
                
                // If turn number is even, then it is black's turn. If it is odd, then white's turn.
                if ($this->turn_num % 2 === 0)
                {
                    $this->cur_color = 'b';
                }
                else
                {
                    $this->cur_color = 'w';
                }
                
                // Set values denoting the client's color, and update that the client's color is in the game.
                if ($this->client_id == $row["white_id"])
                {
                    $this->white_in = TRUE;
                    $this->my_color = 'w';
                }
                else if ($this->client_id == $row["black_id"])
                { 
                    $this->black_in = TRUE;
                    $this->my_color='b';
                }
                
                if ($this->my_color == $this->cur_color) $this->clients_turn=TRUE;
                $conn->close();
            }
        }
        else if ($result->num_rows < 1)
        {
            $this->game_id = -1;
            echo "Player is not in a game. Re-direct to homepage." . "<br/>";
            $conn->close();
            header("location:player0.php");
        }
        else 
        {
            $this->game_id = -2;
             $conn->close();
             throw new Exception('Multiple instances of player in GAME table.');
        }

        if($this->turn_num === null){
            $this->turn_num = 0;
        }
        
//        // if we have a null board, initiate a fresh board. 
//        if($this->board_rep == null)
//            initNewBoard();
            
//        $init_moves = 0;
        // setPotentialMoves();
    }
// Game Table Value Getters
    public function get_Id_Game() {
        return $this->game_id;
    }
    public function get_Id_Client()
    {
        return $this->client_id;
    }
    public function get_Id_White() {
        return $this->white_id;
    }
    public function get_Id_Black() {
        return $this->black_id;   
    }
    public function get_Username_White() {
        return $this->white_username;
    }
    public function get_Username_Black() {
        return $this->black_username;
    }
    public function in_Game_White() {
        return $this->white_in;
    }
    public function in_Game_Black() {
        return $this->black_in;
    }
    public function get_Turn_Number() {
        return $this->turn_num;
    }
    public function get_Board_Representation() {
        return $this->board_rep;   
    }
    // NOTE: Do we want a similar pair of functions that act as: "get_My_Pieces() and get_Opponent_Pieces()?"
    public function get_Pieces_White() {
        return $this->white_pieces;
    }
    public function get_Pieces_Black() {
        return $this->black_pieces;
    }
    
// Session-specific Getters
    public function get_Current_Color() {
        return $this->cur_color;
    }
    public function is_Clients_Turn() {
       return $this->clients_turn;
    }
    public function get_Potential_Moves() {
        return $this->potential_moves;
    }
    
// Setters
    public function increment_Turn_Number() {
        $this->turn_num++;
    }
    public function set_Potential_Moves($pot_moves) {
        $this->potential_moves = $pot_moves;
    }
    public function set_White_Pieces($white_json){
        $this->white_pieces = $white_json;
    }
    public function set_Black_Pieces($black_json){
        $this->black_pieces = $black_json;
    }
    
// Updaters
    public function update_Game()
    {
        $db_host = 'mysql.cs.iastate.edu';
        $db_user = 'u309M13';
        $db_pass = 'T2GWRYDIw';
        $db_name = 'db309M13';
        $tbl_name = 'Game';

        //Create connection
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);        
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "UPDATE $tbl_name 
                SET turn_num = '$this->turn_num' ,
                    white_in = '$this->white_in' ,
                    black_in = '$this->black_in' ,
                    board_json = '$this->board_rep'
                WHERE game_id = '$this->game_id'";
        
        // Query the database with our statement. 
        if ($conn->query($sql) === TRUE) 
        {
            echo "Game successfully updated." . "<br/>";
        }
        else
        {
                echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        //Close the database connection
        $conn->close();
    }
    
/*    public function end_Game()
    {
            $db_host = 'mysql.cs.iastate.edu';
            $db_user = 'u309M13';
            $db_pass = 'T2GWRYDIw';
            $db_name = 'db309M13';           
            $tbl_name = 'Game';
            
            // Create connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
            
            // Define DELETE statement.
            $sql = "DELETE FROM $tbl_name WHERE game_id = '$this->game_id'";
            
            // Query the database with our statement. 
            if ($conn->query($sql) === TRUE) 
            {
                echo "Game successfully ended." . "<br/>";
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            // Close database connection. 
            $conn->close();        
    }*/
    
/*    public function initNewBoard(){
            
           $PAWN = 0;
           $KNIGHT = 1;
           $BISHOP = 2;
           $ROOK = 3;
           $QUEEN = 4;
           $KING = 5;
         
           $json = ' "black":  [{ "piece": ROOK,  "row": 0, "col": 0, "status": UNCAPTURED },
                                { "piece": KNIGHT,"row": 0, "col": 1, "status": UNCAPTURED },
                                { "piece": BISHOP,"row": 0, "col": 2, "status": UNCAPTURED },
                                { "piece": KING,  "row": 0, "col": 3, "status": UNCAPTURED },
                                { "piece": QUEEN, "row": 0, "col": 4, "status": UNCAPTURED },
                                { "piece": BISHOP,"row": 0, "col": 5, "status": UNCAPTURED },
                                { "piece": KNIGHT,"row": 0, "col": 6, "status": UNCAPTURED },
                                { "piece": ROOK,  "row": 0, "col": 7, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 1, "col": 0, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 1, "col": 1, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 1, "col": 2, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 1, "col": 3, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 1, "col": 4, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 1, "col": 5, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 1, "col": 6, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 1, "col": 7, "status": UNCAPTURED }, ],
                     "white": [ { "piece": ROOK,  "row": 7, "col": 0, "status": UNCAPTURED },
                                { "piece": KNIGHT,"row": 7, "col": 1, "status": UNCAPTURED },
                                { "piece": BISHOP,"row": 7, "col": 2, "status": UNCAPTURED },
                                { "piece": KING,  "row": 7, "col": 3, "status": UNCAPTURED },
                                { "piece": QUEEN, "row": 7, "col": 4, "status": UNCAPTURED },
                                { "piece": BISHOP,"row": 7, "col": 5, "status": UNCAPTURED },
                                { "piece": KNIGHT,"row": 7, "col": 6, "status": UNCAPTURED },
                                { "piece": ROOK,  "row": 7, "col": 7, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 6, "col": 0, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 6, "col": 1, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 6, "col": 2, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 6, "col": 3, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 6, "col": 4, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 6, "col": 5, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 6, "col": 6, "status": UNCAPTURED },
                                { "piece": PAWN,  "row": 6, "col": 7, "status": UNCAPTURED }, ]';

        $this->board_rep = json_decode($json, true);
        var_dump($this->board_rep);
    
 } */
}
?>