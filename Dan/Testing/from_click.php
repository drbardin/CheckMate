<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include_once "classGame.php";
require_once "engine.php";
?>
<?php
    // This file decodes a JS/Canvas click object and sends it to validate_move.php
    $myJson = json_decode($_POST['data'], true);
    $r = $myJson['row'];
    $c = $myJson['col'];
    
    // call PHP function to produce legal moves for square clicked. 
   // $newArray = getPotentialMoves($r, $c);
    $newArray = array(array('row'=>$r,'col'=>$c));
    $shits_and_gigs = new Game;
    if ($shits_and_gigs->is_Clients_Turn())
    {
        $shits_and_gigs->increment_Turn_Number();
        $shits_and_gigs->update_Game();
    }
    echo json_encode($newArray);
?>