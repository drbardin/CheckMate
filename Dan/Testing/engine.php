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
        $incoming_board = $game->get_Board_Representation();
        $board = unserialize($incoming_board);
        
        // convert (row,col) to array index 0-63
        $sqr_index = ($r * 7) + $r + $c;
        $switch_var = $board[$sqr_index]['piece'];

        var_dump("row: " . $r );
  
        $highlight_arr = array(array());
        switch($switch_var)
        {
            case 0: //pawn
                $highlight_arr = movePawn($r, $c, $sqr_index, $cur_color, $board);
                break;
            case 3: //rook
                $highlight_arr = moveRook($r, $c, $sqr_index, $cur_color, $board);
                break;
            case 1: //knight
                $highlight_arr = moveKnight($r, $c, $sqr_index, $cur_color, $board);
                break;
            case 2: //bishop
                $highlight_arr = moveBishop($r, $c, $sqr_index, $cur_color, $board);
                break;
            case 4: //queen
                $highlight_arr = moveQueen($r, $c, $sqr_index, $cur_color, $board);
                break;
            case 5: //king
                $highlight_arr = moveKing($r, $c, $sqr_index, $cur_color, $board);
                break;
            default :
                $highlight_arr[0]['row'] = $r;
                $highlight_arr[0]['col'] = $c;
                var_dump("piece switch fell to default " . $switch_var);
        }
        return $highlight_arr;    
    }
}
    
if(!function_exists('movePawn'))
{
    function movePawn($r, $c, $sqr_index, $color, $board)
    {
        // 2d array to hold potential moves. 
        // always highlight this.piece 
        $moves = array(array('row'=>$r, 'col'=>$c));
        
        // On home row, open move available. 
        if($color === 'b')
        {
            // check if forward movement would go oob, and if that index is empty.
            if($r < 8 && $board[$sqr_index+8]['id'] === 0)    
            {
                $mve = array(array('row'=>$r+1, 'col'=>$c));
                array_push($moves, $mve);
            }
            
            // if not oob, not this.color, and not empty --> capture condition. 
            if($c < 7 && $board[$sqr_index+9]['id'] < 200 && $board[$sqr_index+9]['id'] !== 0)
            {
                $mve = array(array('row'=>$r+1, 'col'=>$c+1));
                array_push($moves, $mve);
            }
            
            if($c > 0 && $board[$sqr_index+7]['id'] < 200 && $board[$sqr_index+7]['id'] !== 0)
            {
                $mve = array(array('row'=>$r+1, 'col'=>$c-1));
                array_push($moves, $mve);
            }
            
        }// color == white
        else
        {
            // check if forward movement would go oob, and if that index is empty.
            if($r >= 0 && $board[$sqr_index-8]['id'] === 0)    
            {
                $mve = array(array('row'=>$r-1, 'col'=>$c));
                array_push($moves, $mve);
            }
            
            // if not oob, not this.color, and not empty --> capture condition. 
            if($c > 0 && $board[$sqr_index-9]['id'] > 199 && $board[$sqr_index-9]['id'] !== 0)
            {
                $mve = array(array('row'=>$r-1, 'col'=>$c-1));
                array_push($moves, $mve);
            }
            
            if($c < 7 && $board[$sqr_index-7]['id'] < 200 && $board[$sqr_index-7]['id'] !== 0)
            {
                $mve = array(array('row'=>$r-1, 'col'=>$c+1));
                array_push($moves, $mve);
            }
        }

        return $moves;
    }
}

if(!function_exists('moveRook'))
{
    function moveRook($r, $c, $sqr_index, $color, $board) {

        $moves = array(array('row'=>$r, 'col'=>$c));
        
        // logic is from white's perspective.
        // left movement
        for($i = 0; $i < (7 - $c); $i++)
        {
            if($board[$sqr_index-$i]['id'] !== 0)
            {
                // check if is opposing piece and break. 
                if($color === 'w' && $board[$sqr_index-$i]['id'] > 199 ||
                  $color === 'b' && $board[$sqr_index-$i]['id'] < 200 )
                {
                    $mve = array(array('row'=>$r, 'col'=>$c-$i));
                    array_push($moves, $mve);
                }    
                //piece stops movement
                break;
            }
            // empty square, push onto 
            $mve = array(array('row'=>$r, 'col'=>$c-1));
            array_push($moves, $move);
        }
        
        // right movement
        for($i = 0; $i < $c; $i++)
        {
            if($board[$sqr_index+$i]['id'] !== 0)
            {
                // check if is opposing piece and break. 
                if($color === 'w' && $board[$sqr_index+$i]['id'] > 199 ||
                  $color === 'b' && $board[$sqr_index+$i]['id'] < 200 )
                {
                    $mve = array(array('row'=>$r, 'col'=>$c+$i));
                    array_push($moves, $mve);
                }    
                //piece stops movement
                break;
            }
            // empty square, push onto 
            $mve = array(array('row'=>$r, 'col'=>$c+$i));
            array_push($moves, $move);
        }
        
        // forward movement
        for($i = 0; $i < (7 - $r); $i++)
        {
            
            if($board[$sqr_index+$i]['id'] !== 0)
            {
                // check if is opposing piece and break. 
                if($color === 'w' && $board[$sqr_index+$i+8]['id'] > 199 ||
                  $color === 'b' && $board[$sqr_index+$i+8]['id'] < 200 )
                {
                    $mve = array(array('row'=>$r+$i, 'col'=>$c));
                    array_push($moves, $mve);
                }    
                //piece stops movement
                break;
            }
            // empty square, push onto 
            $mve = array(array('row'=>$r+$i, 'col'=>$c));
            array_push($moves, $move);
        }
        
        // backward movement
        for($i = 0; $i < $r; $i++)
        {
            if($board[$sqr_index-$i]['id'] !== 0)
            {
                // check if is opposing piece and break. 
                if($color === 'w' && $board[$sqr_index+$i-8]['id'] > 199 ||
                  $color === 'b' && $board[$sqr_index+$i-8]['id'] < 200 )
                {
                    $mve = array(array('row'=>$r-$i, 'col'=>$c));
                    array_push($moves, $mve);
                }    
                //piece stops movement
                break;
            }
            // empty square, push onto 
            $mve = array(array('row'=>$r-$i, 'col'=>$c));
            array_push($moves, $move);
        }
        
        return $moves; 
    } // end moveRook
}

if(!function_exists('moveKnight'))
{
    function moveKnight($r, $c, $sqr_index, $color, $board) {

        $moves = array(array('row'=>$r, 'col'=>$c));

        // this if checks if the move will go off the board.
        if($r-2 >= 0 && $c-1 >=0)
        {
            // now look at the index and see what's there.
            if($board[$sqr_index-17]['id'] === 0)
            {
                $mve =  array(array('row'=>$r-2, 'col'=>$c-1));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index-17]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index-17]['id'] < 200 ) {

                $mve =  array(array('row'=>$r-2, 'col'=>$c-1));
                array_push($moves, $mve);
            }

        }
        if($r-2 >= 0 && $c+1 < 8)
        {
            // now look at the index and see what's there.
            if($board[$sqr_index-15]['id'] === 0)
            {
                $mve =  array(array('row'=>$r-2, 'col'=>$c+1));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index-15]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index-15]['id'] < 200 ) {

                $mve =  array(array('row'=>$r-2, 'col'=>$c+1));
                array_push($moves, $mve);
            }
        }
        if($r-1 >= 0 && $c-2 >=0)
        {
            // now look at the index and see what's there.
            if($board[$sqr_index-10]['id'] === 0)
            {
                $mve =  array(array('row'=>$r-1, 'col'=>$c-2));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index-10]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index-10]['id'] < 200 ) {

                $mve =  array(array('row'=>$r-1, 'col'=>$c-2));
                array_push($moves, $mve);
            }
        }
        if($r-1 >= 0 && $c+2 < 8)
        {
            // now look at the index and see what's there.
            if($board[$sqr_index-10]['id'] === 0)
            {
                $mve =  array(array('row'=>$r-1, 'col'=>$c-2));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index-10]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index-10]['id'] < 200 ) {

                $mve =  array(array('row'=>$r-1, 'col'=>$c-2));
                array_push($moves, $mve);
            }
        }
        if($r+2 < 8 && $c-1 >= 0)
        {
            // now look at the index and see what's there.
            if($board[$sqr_index+15]['id'] === 0)
            {
                $mve =  array(array('row'=>$r+2, 'col'=>$c-1));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index+15]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index+15]['id'] < 200 ) {

                $mve =  array(array('row'=>$r+2, 'col'=>$c-1));
                array_push($moves, $mve);
            }
        }
        if($r+2 < 8 && $c+1 < 8)
        {
            if($board[$sqr_index+17]['id'] === 0)
            {
                $mve =  array(array('row'=>$r+2, 'col'=>$c+1));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index+17]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index+17]['id'] < 200 ) {

                $mve =  array(array('row'=>$r+2, 'col'=>$c+1));
                array_push($moves, $mve);
            }
        }
        if($r+1 < 8 && $c-2 >=0)
        {
            if($board[$sqr_index+6]['id'] === 0)
            {
                $mve =  array(array('row'=>$r+1, 'col'=>$c-2));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index+6]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index+6]['id'] < 200 ) {

                $mve =  array(array('row'=>$r+1, 'col'=>$c-2));
                array_push($moves, $mve);
            }
        }
        if($r+1 < 8 && $c+2 < 8)
        {
            if($board[$sqr_index+10]['id'] === 0)
            {
                $mve =  array(array('row'=>$r+1, 'col'=>$c+2));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index+10]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index+10]['id'] < 200 ) {

                $mve =  array(array('row'=>$r+1, 'col'=>$c+2));
                array_push($moves, $mve);
            }
        }

        return $moves;
    }
}

if(!function_exists('moveBishop'))
{
    function moveBishop($r, $c, $sqr_index, $color, $board) {
        $moves = array(array('row'=>$r, 'col'=>$c));
        
        //backward, left diag
        for($i = 0; $i < (7 - $r); $i++)
        {
            
            if($board[$sqr_index+7]['id'] !== 0)
            {
                // check if is opposing piece and break. 
                if($color === 'w' && $board[$sqr_index+7]['id'] > 199 ||
                  $color === 'b' && $board[$sqr_index+7]['id'] < 200 )
                {
                    $mve = array(array('row'=>$r+1, 'col'=>$c-1));
                    array_push($moves, $mve);
                }    
                //piece stops movement
                break;
            }
            // empty square, push onto 
            $mve = array(array('row'=>$r+1, 'col'=>$c-1));
            array_push($moves, $move);
        }
        
        for($i = 0; $i < (7 - $r); $i++)
        {
            
            if($board[$sqr_index+9]['id'] !== 0)
            {
                // check if is opposing piece and break. 
                if($color === 'w' && $board[$sqr_index+9]['id'] > 199 ||
                  $color === 'b' && $board[$sqr_index+9]['id'] < 200 )
                {
                    $mve = array(array('row'=>$r+1, 'col'=>$c+1));
                    array_push($moves, $mve);
                }    
                //piece stops movement
                break;
            }
            // empty square, push onto 
            $mve = array(array('row'=>$r+1, 'col'=>$c+1));
            array_push($moves, $move);
        }
        
        // forward, left diag
        for($i = 0; $i < (7 - $c); $i++)
        {
            
            if($board[$sqr_index-9]['id'] !== 0)
            {
                // check if is opposing piece and break. 
                if($color === 'w' && $board[$sqr_index-9]['id'] > 199 ||
                  $color === 'b' && $board[$sqr_index-9]['id'] < 200 )
                {
                    $mve = array(array('row'=>$r-1, 'col'=>$c-1));
                    array_push($moves, $mve);
                }    
                //piece stops movement
                break;
            }
            // empty square, push onto 
            $mve = array(array('row'=>$r-1, 'col'=>$c-1));
            array_push($moves, $move);
        }
        
        // forward, rigt diag
        for($i = 0; $i < (7 - $c); $i++)
        {
            if($board[$sqr_index-7]['id'] !== 0)
            {
                // check if is opposing piece and break. 
                if($color === 'w' && $board[$sqr_index-7]['id'] > 199 ||
                  $color === 'b' && $board[$sqr_index-7]['id'] < 200 )
                {
                    $mve = array(array('row'=>$r-1, 'col'=>$c+1));
                    array_push($moves, $mve);
                }    
                //piece stops movement
                break;
            }
            // empty square, push onto 
            $mve = array(array('row'=>$r-1, 'col'=>$c+1));
            array_push($moves, $move);
        }
        
        
        return $moves;
    }
}

if(!function_exists('moveQueen'))
{
    function moveQueen($r, $c, $sqr_index, $color, $board) {
        $moves = array(array('row'=>$r, 'col'=>$c));
        
        // queen has move ability of rook & bishop. Call those functions.
        $rook_moves = moveRook($r, $c, $sqr_index, $color, $board);
        $bishop_moves = moveBishop($r, $c, $sqr_index, $color, $board);
        
        array_push($moves, $rook_moves);
        array_push($moves, $bishop_moves);
        
        return $moves;
    }
}

if(!function_exists('moveKing'))
{
    function moveKing($r, $c, $sqr_index, $color, $board) {
        $moves = array(array('row'=>$r, 'col'=>$c));
        
        // this if checks if the move will go off the board.
        if($r-1 >= 0 && $c-1 >=0)
        {
            // now look at the index and see what's there.
            if($board[$sqr_index-9]['id'] === 0)
            {
                $mve =  array(array('row'=>$r-1, 'col'=>$c-1));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index-9]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index-9]['id'] < 200 ) {

                $mve =  array(array('row'=>$r-1, 'col'=>$c-1));
                array_push($moves, $mve);
            }
        }
        if($r-1 >= 0)
        {
            // now look at the index and see what's there.
            if($board[$sqr_index-8]['id'] === 0)
            {
                $mve =  array(array('row'=>$r-1, 'col'=>$c));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index-8]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index-8]['id'] < 200 ) {

                $mve =  array(array('row'=>$r-1, 'col'=>$c));
                array_push($moves, $mve);
            }
        }
        if($r-1 >= 0 && $c+1 < 8)
        {
            // now look at the index and see what's there.
            if($board[$sqr_index-7]['id'] === 0)
            {
                $mve =  array(array('row'=>$r-1, 'col'=>$c+1));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index-7]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index-7]['id'] < 200 ) {

                $mve =  array(array('row'=>$r-1, 'col'=>$c+1));
                array_push($moves, $mve);
            }
        }
        if($c-1 >= 0)
        {
            // now look at the index and see what's there.
            if($board[$sqr_index-1]['id'] === 0)
            {
                $mve =  array(array('row'=>$r, 'col'=>$c-1));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index-1]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index-1]['id'] < 200 ) {

                $mve =  array(array('row'=>$r, 'col'=>$c-1));
                array_push($moves, $mve);
            }
        }
        if($c+1 < 8)
        {
            // now look at the index and see what's there.
            if($board[$sqr_index+1]['id'] === 0)
            {
                $mve =  array(array('row'=>$r, 'col'=>$c+1));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index+1]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index+1]['id'] < 200 ) {

                $mve =  array(array('row'=>$r, 'col'=>$c+1));
                array_push($moves, $mve);
            }
        }
        if($r+1 < 8 && $c-1 >= 0)
        {
            if($board[$sqr_index+7]['id'] === 0)
            {
                $mve =  array(array('row'=>$r+1, 'col'=>$c-1));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index+7]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index+7]['id'] < 200 ) {

                $mve =  array(array('row'=>$r+1, 'col'=>$c-1));
                array_push($moves, $mve);
            }
        }
        if($r+1 < 8)
        {
            if($board[$sqr_index+8]['id'] === 0)
            {
                $mve =  array(array('row'=>$r+1, 'col'=>$c));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index+8]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index+8]['id'] < 200 ) {

                $mve =  array(array('row'=>$r+1, 'col'=>$c));
                array_push($moves, $mve);
            }
        }
        if($r+1 < 8 && $c+1 < 8)
        {
            if($board[$sqr_index+9]['id'] === 0)
            {
                $mve =  array(array('row'=>$r+1, 'col'=>$c+1));
                array_push($moves, $mve);
            }
            else if($color === 'w' && $board[$sqr_index+9]['id'] > 199 ||
                $color === 'b' && $board[$sqr_index+9]['id'] < 200 ) {

                $mve =  array(array('row'=>$r+1, 'col'=>$c+1));
                array_push($moves, $mve);
            }
        }
        
        return $moves;
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

if(!function_exists('checkForCheck'))
{
    function checkForCheck() {
        return -1;
    }
}
?>