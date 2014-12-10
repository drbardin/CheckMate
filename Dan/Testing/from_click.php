<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once "engine.php";
?>
<?php

    // This file decodes a JS/Canvas click object and sends it to validate_move.php
    //$myJson = json_decode($_POST['data'], true);
    $myJson = json_decode($_POST['data'], true);
    $r = $myJson['row'];
    $c = $myJson['col'];

    $newArray = array(array('row'=>$r, 'col'=>$c));
// call PHP function to produce legal moves for square clicked. 
//$newArray = getPotentialMoves($r, $c);

    echo json_encode($newArray);
?>
