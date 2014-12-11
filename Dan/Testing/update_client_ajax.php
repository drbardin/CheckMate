<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include_once "classGame.php";
//session_start();
?>
<?php
    $values = new Game;
    $turn_num = $values->get_Turn_Number();
    $last_move = $values->get_Last_Move();
    $my_array = array($turn_num,$last_move);
    echo json_encode($my_array);
?>