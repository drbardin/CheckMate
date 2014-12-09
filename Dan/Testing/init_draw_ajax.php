<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include_once "classGame.php";
session_start();
?>
<?php
    $values = new Game;
    $client_username;
    $client_color;
    $opponent_username;
    $if ($values->get_Client_Color()=='w')
    {
        $client_username = $values->get_Username_White();
        $client_color = 'w';
        $opponent_username = $values->get_Username_Black();
    }
    else if ($values->get_Client_Color()=='b')
    {
        $client_username = $values->get_Username_Black();
        $client_color = 'b';
        $opponent_username = $values->get_Username_White();
    }
    else
    {
        echo "THIS IS NOT RIGHT....BAD CODE!..VERY BAD.";
    }
    $my_array = array($client_username, $client_color, $opponent_username);
    echo json_encode($my_Array);
?>