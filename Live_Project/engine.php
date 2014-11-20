<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    include_once "classGame.php";
//    session_start();
?> 

<?php

if (!function_exists('processMove'))
{
    // this will process a move
    function processMove($r, $c)
    {
        $game = new Game();
        
        // ask validate move function if destination click is valid. 
        //$isGoodMove = validateMove($r, $c);
        // short circuit above.
        $isGoodMove = true;

        if($isGoodMove){

            $game->incrementTurnNum();// update turn
            $game->setCurColor(); // flip color
            // update object array here
            return true; // tell AJAX this move is good, to_click can draw move. 
        }
    }
}

if(!function_exists('getPotentialMoves'))
{
   // pass the initial board if turn_num == 0 
    
    // this will process an initial click and get valid moves, and return highlights. 
    function getPotentialMoves($r, $c, $black, $white)
    {
        $game = new Game();
        
        // Boards haven't been 
        if ($game->getTurnNum == 0)
        
        $clr = $game->getCurColor();
        $board = $game->getBoardRep(); // full set of pieces
        $color_set; // black or white array of pieces. 
        $switch_var = "PAWN"; 
        
        if($clr == "b")
            $color_set = $board['black'];
        else
            $color_set = $board['white'];
        
        var_dump($color_set);
        
        for($i = 0; $i < count($color_set); $i++)
        {
            if($color_set[$i]['row'] == $r && $color_set[$i]['col'] == $c)
            {
                // we found the clicked piece. 
                // now pass it to switch to route to the logic function.
                $switch_var = $color_set[$i]['piece'];
            }
        }
  
        $highlight_arr;

        switch($switch_var)
        {
            case "PAWN" :
                $highlight_arr = movePawn($r, $c, $clr, $board);
                break;
            case "ROOK" :
                $highlight_arr = moveRook($r, $c, $clr, $board);
                break;
            case "KNIGHT" :
                $highlight_arr = moveKnight($r, $c, $clr, $board);
                break;
            case "BISHOP" :
                $highlight_arr = moveBishop($r, $c, $clr, $board);
                break;
            case "QUEEN" :
                $highlight_arr = moveQueen($r, $c, $clr, $board);
                break;
            case "KING" :
                $highlight_arr = moveKing($r, $c, $clr, $board);
                break;
            default :
                $highlight_arr[0] = array();
                push_array($highligh_arr[0], $r, $c); 
        }
        return $highlight_arr;    
    }
}
    // SHORT CIRCUITED OUT FOR THE MOMENT
    public function validateMove($r, $c) {
        $move_list = getPotentialMoves();
        
        for($i = 0; $i < count($move_list); $i++)
        {
            if($move_list[$i]->row == $r && $move_list[$i]->col == $c)
                return true;
        }
        return false; //selected move not available.
    }
    
if(!function_exists('movePawn'))
{
    function movePawn($r, $c, $color, $cur_board){
        
        // Quick and dirty for demo. 
        $moves = array();
        $moves[0] = array();
        $moves[1] = array();
        $moves[2] = array();
        
        array_push($moves[0], $r, $c);
        
        if($color == "b")
        {
            array_push($moves[1], $r-1, $c);
            array_push($moves[2], $r-2, $c);
        }
        else
        {
            array_push($moves[1], $r+1, $c);
            array_push($moves[2], $r+2, $c);
        }

        return $moves;
        
        if($color == "b")
            $color_set = $board['black'];
        else
            $color_set = $board['white'];
        
        for($i = 0; $i < count($color_set); $i++)
        {
            if($color_set[$i]['row'] == $r && $color_set[$i]['col'] == $c)
            {
                // we found the clicked piece. 
                // now pass it to switch to route to the logic function.
                $switch_var = $color_set[$i]['piece'];
            }
        }
    }
}

if(!function_exists('moveRook'))
{
    function moveRook($r, $c, $color, $cur_board) {
        return -1;
    }
}

if(!function_exists('moveKnight'))
{
    function moveKnight($r, $c, $color, $cur_board) {
      
        // Quick and dirty for demo. 
        $moves = array();
        $moves[0] = array();
        $moves[1] = array();
        $moves[2] = array();
        
        array_push($moves[0], $r, $c);
        
        if($color == "b")
        {
            array_push($moves[1], $r-2, $c-1);
            array_push($moves[2], $r-2, $c+1);
        }
        else
        {
            array_push($moves[1], $r+2, $c-1);
            array_push($moves[2], $r+2, $c+1);
        }

        return $moves;
    }
}

if(!function_exists('moveBishop'))
{
    function moveBishop($r, $c, $color, $cur_board) {
        return -1;
    }
}

if(!function_exists('moveQueen'))
{
    function moveQueen($r, $c, $color, $cur_board) {
        return -1;
    }
}

if(!function_exists('moveKing'))
{
    function moveKing($r, $c, $color, $cur_board) {
        return -1;
    }
}

if(!function_exists('checkForCheck'))
{
    function checkForCheck() {
        return -1;
    }
}
?>