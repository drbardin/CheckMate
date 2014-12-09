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
            $game->incrementTurnNum();// update turn
            $game->setCurColor(); // flip color
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
        
        for($i = 0; $i < count($color_set); $i++)
        {
            if($color_set[$i]['row'] === $r && $color_set[$i]['col'] === $c)
            {
                // we found the clicked piece. 
                // now pass it to switch to route to the logic function.
                $switch_var = $color_set[$i]['piece'];
                break;
            }
        }
  
        $highlight_arr = array(array());
        switch($switch_var)
        {
            case "PAWN":
                $highlight_arr = movePawn($r, $c, $cur_color,   $black, $white);
                break;
            case "ROOK":
                $highlight_arr = moveRook($r, $c, $cur_color,   $black, $white);
                break;
            case "KNIGHT":
                $highlight_arr = moveKnight($r, $c, $cur_color, $black, $white);
                break;
            case "BISHOP":
                $highlight_arr = moveBishop($r, $c, $cur_color, $black, $white);
                break;
            case "QUEEN":
                $highlight_arr = moveQueen($r, $c, $cur_color,  $black, $white);
                break;
            case "KING":
                $highlight_arr = moveKing($r, $c, $cur_color,   $black, $white);
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
    function movePawn($r, $c, $color, $black, $white)
    {
        // 2d array to hold potential moves. 
        // always highlight this.piece 
        $moves = array(array('row'=>$r, 'col'=>$c));
        
        // boolean flag if next position forward is empty. 
        $fwd_1_open = TRUE;
        $fwd_2_open = FALSE;
        
        // we need to route for color, 
        if($color === 'b') 
        {   
            // loop through color sets for capture and move ability.
            for($i = 0; $i < count($black); $i++)
            {
                // if pawn is on homerow, check if two forward is occupied.
                if($r === 6) 
                {
                     $fwd_2_open = TRUE;
                    if($black[$i]['row'] === $r-2 && $black[$i]['col'] === $c)
                        $fwd_2_open = FALSE;
                    if($white[$i]['row'] === $r-2 && $white[$i]['col'] === $c)
                        $fwd_2_open = FALSE;
                }
                
                // if square directly ahead of pawn is occupied, can't move there. 
                if($black[$i]['row'] === $r-1 && $black[$i]['col'] === $c)
                    $fwd_1_open = FALSE;
                if($white[$i]['row'] === $r-1 && $white[$i]['col'] === $c)
                    $fwd_1_open = FALSE;   
                
                // pawn capture left condition
                if($black[$i]['row'] === $r-1 && $black[$i]['col'] === $c-1){
                    $l_capture = array('row'=>$r-1, 'col'=>$c-1);
                    array_push($moves, $l_capture);
                }
                
                // pawn capture right condition
                if($black[$i]['row'] === $r-1 && $black[$i]['col'] === $c+1){
                    $r_capture = array('row'=>$r-1, 'col'=>$c-1);
                    array_push($moves, $r_capture);
                }
            }
        }
        else 
        {
            // loop through color sets for capture and move ability.
            for($i = 0; $i < count($white); $i++)
            {
                // if pawn is on homerow, check if two forward is occupied.
                if($r === 1) 
                {
                    $fwd_2_open = TRUE;
                    if($black[$i]['row'] === $r+2 && $black[$i]['col'] === $c)
                        $fwd_2_open = FALSE;
                    if($white[$i]['row'] === $r+2 && $white[$i]['col'] === $c)
                        $fwd_2_open = FALSE;
                }
                
                // if square directly ahead of pawn is occupied, can't move there. 
                if($black[$i]['row'] === $r+1 && $black[$i]['col'] === $c)
                    $fwd_1_open = FALSE;
                if($white[$i]['row'] === $r+1 && $white[$i]['col'] === $c)
                    $fwd_1_open = FALSE;   
                
                // pawn capture left condition
                if($black[$i]['row'] === $r+1 && $black[$i]['col'] === $c-1){
                    $l_capture = array('row'=>$r-1, 'col'=>$c-1);
                    array_push($moves, $l_capture);
                }
                
                // pawn capture right condition
                if($black[$i]['row'] === $r+1 && $black[$i]['col'] === $c+1){
                    $r_capture = array('row'=>$r-1, 'col'=>$c-1);
                    array_push($moves, $r_capture);
                }
            }
            // can pawn move forward? 
            if($fwd_1_open){
                $upone = array('row'=>$r-1, 'col'=>$c);
                array_push($moves, $upone);
            }
        }
        return $moves;
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
      
        $moves;
        
        if($color === 'w'){
            $moves = array(array('row'=>$r, 'col'=>$c),array('row'=>$r-1, 'col'=>$c),array('row'=>$r-2, 'col'=>$c)); 
        }
        else{
            $moves = array(array('row'=>$r, 'col'=>$c),array('row'=>$r+1, 'col'=>$c),array('row'=>$r+2, 'col'=>$c)); 
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
