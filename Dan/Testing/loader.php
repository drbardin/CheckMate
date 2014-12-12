<?php
// This file simply decodes a click-data JSON and then echoes back an encoded copy of it.
    $myJson = json_decode($_POST['data'], true);
    $r = $myJson['row'];
    $c = $myJson['col'];
    $newArray = array(
        "row" => $r,
        "col" => $c
    );
    header('Content-Type: application/json');
    echo json_encode($newArray);
?>