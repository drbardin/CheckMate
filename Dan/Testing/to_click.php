<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include_once "engine.php";
?>
<?php
    
// This file decodes a JS/Canvas click object and sends it to validate_move.php
//var_dump($myJson) = $_POST['data'];
$myJson = json_decode($_POST['data'], true);
$r = $myJson['row'];
$c = $myJson['col'];
    
$outgoing; 
if(processMove($r, $c)){
    $outgoing = 'true';
}
else {
    $outgoing = 'false';
}

echo json_encode($outgoing);
?>