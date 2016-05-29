<?php
include_once "classPlayer.php";
include_once "engine.php";
session_start();
?>
<?php
// game object definition
class Game
{
    private $game_id;
    private $white_id;
    private $black_id;
    private $white_username;
    private $black_username;
    private $turn_num;
    private $black_pieces;
    private $white_pieces;
    private $cur_color; // either "w" or "b"
    private $my_turn; //true/false
    private $board_rep = array(array());
    public  $potential_moves = array();

    public function __constructor()
    {
        // TODO -> where are we storing array of player objects? 
        // TYLER: Why do we need an array of player objects?
        // DAN: We don't disregard that statement. 
        
        $client_id = $_SESSION["player"]->get_Id();
        
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = 'root';
        $db_name = 'db309M13';
        $db_port  = 8889;
        $tbl_name = 'Game';

        //Create connection
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql      = "SELECT * FROM $tbl_name WHERE '$client_id' = white_id OR '$client_id' = black_id";
        $result   = $conn->query($sql);

        // If result matched $username and $password, table row must be 1 row
        if ($result->num_rows == 1)
        {
            echo "This player is in a Game." . "<br/>";
            if ($row = $result->fetch_assoc())
            {
                $this->game_id = $row["game_id"];
                $this->turn_num = $row["turn_num"];
                $this->white_username = $row[" "];
                $this->black_username = $row[" "];
               // $this->board_rep = $row["board_json"];
                $this->white_id = $row["white_id"];
                $this->black_id = $row["black_id"];
                $this->cur_color = $row["cur_color"];
                $this->black_json = $row["black_json"];
                $this->white_json = $row["white_json"]
                
                if ($client_id == $row["white_id"])
                {
                    $this->cur_color='w';
                    if ($this->turn_num % 2 === 0)
                    {
                        $this->my_turn = FALSE;
                    }
                    
                }
                else if ($client_id == $row["black_id"])
                { 
                    $this->cur_color='b';
                    if ($this->turn_num % 2 === 0)
                    {
                        $this->my_turn = TRUE;
                    }
                }
                // Returns an instance of the Lobby class
                $conn->close;
            }
        }
        else if ($result->num_rows < 1)
        {
            echo "Player is not in a game. Re-direct to homepage." . "<br/>";
            $conn->close();
            header("location:player0.php");
        }
        else 
        {
             $conn->close();
             throw new Exception('Multiple instances of player in GAME table.');
        }
        $conn->close();
        
        if($this->turn_num == null)
            $this->turn_num = 0;
        
//        // if we have a null board, initiate a fresh board. 
//        if($this->board_rep == null)
//            initNewBoard();
            
        $init_moves = 0;
        setPotentialMoves();
    }
    
    public function getGameID(){
        return $this->gameID;
    }
    public function getWhitePlayer() {
        return $this->white_username;
    }
    public function getBlackPlayer() {
        return $this->black_username;
    }
    public function getTurnNum() {
        return $this->turn_num;
    }
    public function incrementTurnNum() {
        $this->turn_num++;
    }
    public function getCurColor(){
        return $this->cur_color;
    }
    public function setCurColor(){
        if($this->cur_color == 'b')
            $this->cur_color = 'w';
        else
            $this->cur_color = 'b';
    }
    public function getBoardRep(){
        return $this->board_rep;
    }
    public function setPotentialMoves($pot_moves){
        $this->potential_moves = $pot_moves;
    }
    public function getPotentialMoves(){
        return $this->potential_moves; 
    }
    public function getWhiteJSON(){
        return $this->white_pieces;
    }
    public function getBlackJSON(){
        return $this->black_json;
    }
    public function setWhiteJSON($white_arr){
        $this->white_json = $white_arr;
    }
    public function setBlackJSON($black_arr){
        $this->black_json = $black_arr;
    }
    
//    public function initNewBoard(){
//            
//           $PAWN = 0;
//           $KNIGHT = 1;
//           $BISHOP = 2;
//           $ROOK = 3;
//           $QUEEN = 4;
//           $KING = 5;
//         
//           $json = ' "black":  [{ "piece": ROOK,  "row": 0, "col": 0, "status": UNCAPTURED },
//                                { "piece": KNIGHT,"row": 0, "col": 1, "status": UNCAPTURED },
//                                { "piece": BISHOP,"row": 0, "col": 2, "status": UNCAPTURED },
//                                { "piece": KING,  "row": 0, "col": 3, "status": UNCAPTURED },
//                                { "piece": QUEEN, "row": 0, "col": 4, "status": UNCAPTURED },
//                                { "piece": BISHOP,"row": 0, "col": 5, "status": UNCAPTURED },
//                                { "piece": KNIGHT,"row": 0, "col": 6, "status": UNCAPTURED },
//                                { "piece": ROOK,  "row": 0, "col": 7, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 1, "col": 0, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 1, "col": 1, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 1, "col": 2, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 1, "col": 3, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 1, "col": 4, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 1, "col": 5, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 1, "col": 6, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 1, "col": 7, "status": UNCAPTURED }, ],
//                     "white": [ { "piece": ROOK,  "row": 7, "col": 0, "status": UNCAPTURED },
//                                { "piece": KNIGHT,"row": 7, "col": 1, "status": UNCAPTURED },
//                                { "piece": BISHOP,"row": 7, "col": 2, "status": UNCAPTURED },
//                                { "piece": KING,  "row": 7, "col": 3, "status": UNCAPTURED },
//                                { "piece": QUEEN, "row": 7, "col": 4, "status": UNCAPTURED },
//                                { "piece": BISHOP,"row": 7, "col": 5, "status": UNCAPTURED },
//                                { "piece": KNIGHT,"row": 7, "col": 6, "status": UNCAPTURED },
//                                { "piece": ROOK,  "row": 7, "col": 7, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 6, "col": 0, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 6, "col": 1, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 6, "col": 2, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 6, "col": 3, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 6, "col": 4, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 6, "col": 5, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 6, "col": 6, "status": UNCAPTURED },
//                                { "piece": PAWN,  "row": 6, "col": 7, "status": UNCAPTURED }, ]';
//
//        $this->board_rep = json_decode($json, true);
//        var_dump($this->board_rep);
//    }
}

?>