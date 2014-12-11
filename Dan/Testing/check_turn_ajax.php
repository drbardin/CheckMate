<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include_once "classGame.php";
//session_start();
?>
<?php
    $values = new Game;
    $my_turn = $values->is_Clients_Turn();
    
    $my_array = array($my_turn);
    echo json_encode($my_array);
?>