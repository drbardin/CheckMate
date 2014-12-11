<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    include_once "classGame.php";
//  session_start();
?> 

<?php

if (!function_exists('processMove'))
{
    // this will process a move
    function processMove($r, $c)
    {
        $game = new Game();
        
        // ask validate move function if destination click is valid. 
        // $isGoodMove = validateMove($r, $c);
        // short circuit above.
        $isGoodMove = true;

        if($isGoodMove){
            // update turn
            // flip color
            // update object array here
            return true; // tell AJAX this move is good, to_click can draw move. 
        }
        return false;
    }
}

if(!function_exists('getPotentialMoves'))
{
    // pass the initial board if turn_num == 0 
    // this will process an initial click and get valid moves, and return highlights. 
    function getPotentialMoves($r, $c)
    {
        $game = new Game();
        $cur_color = $game->get_Current_Color();
        $board = $game->get_Board_Representation();

        // convert row/col to array index 0-63
        $sqr_index = ($r * $c) + $r + $c;
        $switch_var = $board[$sqr_index]->piece;
  
        $highlight_arr = array(array());
        switch($switch_var)
        {
            case "PAWN":
                $highlight_arr = movePawn($r, $c, $cur_color, $board);
                break;
            case "ROOK":
                $highlight_arr = moveRook($r, $c, $cur_color, $board);
                break;
            case "KNIGHT":
                $highlight_arr = moveKnight($r, $c, $cur_color, $board);
                break;
            case "BISHOP":
                $highlight_arr = moveBishop($r, $c, $cur_color, $board);
                break;
            case "QUEEN":
                $highlight_arr = moveQueen($r, $c, $cur_color, $board);
                break;
            case "KING":
                $highlight_arr = moveKing($r, $c, $cur_color, $board);
                break;
            default :
                $highlight_arr[0]['row'] = $r;
                $highlight_arr[0]['col'] = $c;
        }
        return $highlight_arr;    
    }
}

// SHORT CIRCUITED OUT FOR THE MOMENT
if(!function_exists('validateMove')){

    function validateMove($r, $c, $game) {
        $move_list  = $game->getPotentialMoves();
        
        for($i = 0; $i < count($move_list); $i++)
        {
            if($move_list[$i]->row == $r && $move_list[$i]->col == $c)
                return true;
        }
        return false; //selected move not available.
    }
}
    
if(!function_exists('movePawn'))
{
    function movePawn($r, $c, $color, $board)
    {
        // 2d array to hold potential moves. 
        // always highlight this.piece 
        $moves = array(array('row'=>$r, 'col'=>$c));
        

        return $moves;
    }
}

if(!function_exists('moveRook'))
{
    function moveRook($r, $c, $color, $board) {

        $moves = array(array('row'=>$r, 'col'=>$c));
        return -1;
    }
}

if(!function_exists('moveKnight'))
{
    function moveKnight($r, $c, $color, $board) {

        $moves = array(array('row'=>$r, 'col'=>$c));
        return $moves;
    }
}

if(!function_exists('moveBishop'))
{
    function moveBishop($r, $c, $color, $board) {
        $moves = array(array('row'=>$r, 'col'=>$c));
        return -1;
    }
}

if(!function_exists('moveQueen'))
{
    function moveQueen($r, $c, $color, $board) {
        $moves = array(array('row'=>$r, 'col'=>$c));
        return -1;
    }
}

if(!function_exists('moveKing'))
{
    function moveKing($r, $c, $color,  $board) {
        $moves = array(array('row'=>$r, 'col'=>$c));
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
