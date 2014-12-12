<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
    include_once "classPlayer.php";
    include_once "classLobby.php";
    session_start();
?>

<?php
    set_time_limit(500);
    $lobby_entry = new Lobby();
    $lobby_entry->add_Player();
    $entry_id = $lobby_entry->get_Player_Id();
    $in_game = FALSE;

    $db_host = 'mysql.cs.iastate.edu';
    $db_user = 'u309M13';
    $db_pass = 'T2GWRYDIw';
    $db_name = 'db309M13';
    $tbl_name = 'Game';

    //Create connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check connection
    if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
    }

    //THIS IS WHERE I WANT A WINDOW TO SHOW UP SAYING "LOOKING FOR OPPONENT"

    // While in_game not true. 
    while($in_game === FALSE)
    {
            $sql      = "SELECT * FROM $tbl_name WHERE '$entry_id' = white_id OR '$entry_id' = black_id";
            $result   = $conn->query($sql);

            // If result matched $username and $password, table row must be 1 row
            if ($result->num_rows > 0)
            {
                echo "This player is in a Game." . "<br/>";
                $in_game = TRUE;
            }
            else
            {
                sleep(8);
            }
    }
    $conn->close();
    header("location:pvp.php");
?>