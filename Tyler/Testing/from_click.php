<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once "engine.php";
?>
<?php
// This file decodes a JS/Canvas click object and sends it to validate_move.php
$myJson = json_decode($_POST['data'], true);

$r = $myJson['row'];
$c = $myJson['col'];
$black = $myJson['black'];
$white = $myJson['white'];

$newArray = array(
    "row" => $r,
    "col" => $c
);

//$newArray = getPotentialMoves($r, $c, $black, $white);
header('Content-Type: application/json');

echo json_encode($newArray);
