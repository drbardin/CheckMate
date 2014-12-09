<?php
include_once "classPlayer.php";
include_once "classGame.php";
session_start();
?>

<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
    header('Content-Type: text/html; charset=utf-8');
    echo "---------------------------------";
    echo "<br/>";
    echo '$_SESSION[player]' . " Variable Test";
    echo "<br/>";
    $this_player = $_SESSION["player"];
    echo "This player's id: " . $this_player->get_Id() . "<br/>";
    echo "<br/>";
    echo "---------------------------------";
    echo "<br/>";
    echo "classPlayer.php: get_Player() Test";
    echo "<br/>";
    $p1 = get_Player($this_player->get_Id());
    $username = $p1->get_Username();
    echo "Expected username: " . $this_player->get_Username() . "<br/>";
    echo "Actual username: " . $username . "<br/>";
    echo "<br/>";
    echo "<br/>";
    echo "---------------------------------";
    echo "<br/>";
    echo "classGame.php: Methods Test";
    echo "<br/>";
    echo "<br/>";
    $this_Game = new Game();
    echo "Game :: get_Id_Game() Test" . "<br/>";
    echo "Expected: " . "16" . "<br/>";
    echo "Actual: " . $this_Game->get_Id_Game() . "<br/>";
    echo "<br/>";
    echo "Game :: get_Id_Client() Test" . "<br/>";
    echo "Expected: " . "7" . "<br/>";
    echo "Actual: " . $this_Game->get_Id_Client() . "<br/>";
    echo "<br/>";
    echo "Game :: get_Id_White() Test" . "<br/>";
    echo "Expected: " . "7" . "<br/>";
    echo "Actual: " . $this_Game->get_Id_White() . "<br/>";
    echo "<br/>";
    echo "Game :: get_Id_Black() Test" . "<br/>";
    echo "Expected: " . "90" . "<br/>";
    echo "Actual: " . $this_Game->get_Id_Black() . "<br/>";
    echo "<br/>";
    echo "Game :: get_Turn_Number() Test" . "<br/>";
    echo "Expected: " . "0" . "<br/>";
    echo "Actual: " . $this_Game->get_Turn_Number() . "<br/>";
    echo "<br/>";
    echo "Game :: get_Username_White() Test" . "<br/>";
    echo "Expected: " . "fake" . "<br/>";
    echo "Actual: " . $this_Game->get_Username_White() . "<br/>";
    echo "<br/>";
    echo "Game :: get_Username_Black() Test" . "<br/>";
    echo "Expected: " . "tyler" . "<br/>";
    echo "Actual: " . $this_Game->get_Username_Black() . "<br/>";
    echo "<br/>";
    echo "Game :: in_Game_White() Test" . "<br/>";
    echo "Expected: " . "0" . "<br/>";
    echo "Actual: " . $this_Game->in_Game_White() . "<br/>";
    echo "<br/>";
    echo "Game :: in_Game_Black() Test" . "<br/>";
    echo "Expected: " . "1" . "<br/>";
    echo "Actual: " . $this_Game->in_Game_Black() . "<br/>";
    echo "<br/>";
    echo "Game :: get_Turn_Number() Test" . "<br/>";
    echo "Expected: " . "0" . "<br/>";
    echo "Actual: " . $this_Game->get_Turn_Number() . "<br/>";
    echo "<br/>";
    echo "Game :: get_Current_Color() Test" . "<br/>";
    echo "Expected: " . "b (because its turn 0)" . "<br/>";
    echo "Actual: " . $this_Game->get_Current_Color() . "<br/>";
    echo "<br/>";
    echo "Game :: is_Clients_Turn() Test" . "<br/>";
    echo "Expected: " . "1 (because it is turn 0)" . "<br/>";
    echo "Actual: " . $this_Game->is_Clients_Turn() . "<br/>";
    echo "<br/>";
    echo "Game :: get_Board_Representation() Test" . "<br/>";
    echo "Expected: " . "(A big long value)" . "<br/>";
    echo "Actual: " . $this_Game->get_Board_Representation() . "<br/>";
    echo "<br/>";
?>