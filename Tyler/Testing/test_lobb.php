<?php
include_once "classPlayer.php";
include_once "classLobby.php";
session_start();
?>

<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
    header('Content-Type: text/html; charset=utf-8');

    echo '$_SESSION' . " Variable Test";
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

    echo "classLobby.php: Methods Test";
    echo "<br/>";
    echo "---------------------------------";
    echo "<br/>";
    echo "Lobby :: get_Player_Id() Test" . "<br/>";
    $lobby_entry = new Lobby();
    echo "Expected: " . $p1->get_Id() . "<br/>";
    echo "Actual: " . $lobby_entry->get_Player_Id() . "<br/>";
    echo "<br/>";
    $lobby_entry->remove_Player($lobby_entry->get_Player_Id());
    $lobby_entry->add_Player();
    echo "Player added at this time: " . $lobby_entry->get_Time_Entered() . "<br/>";  
?>