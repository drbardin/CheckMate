<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once "classGame.php";
require_once "classPiece.php";
//include_once "engine.php";
//session_start();
?>
<?php
    //header("Content-Type: application/json; charset=UTF-8");
    $values = new Game;
    $client_username;
    $client_color;
    $opponent_username;
    $turn_number = $values->get_Turn_Number();
    $board_rep = $values->get_Board_Representation();
    if ($values->get_Client_Color()=='w')
    {
        $client_username = $values->get_Username_White();
        $client_color = 'w';
        $opponent_username = $values->get_Username_Black();
        $values->update_Game();
    }
    else if ($values->get_Client_Color()=='b')
    {
        $client_username = $values->get_Username_Black();
        $client_color = 'b';
        $opponent_username = $values->get_Username_White();
        $values->update_Game();
    }
    else
    {/*error should be here*/
    }

    $board_rep = unserialize($board_rep);
    $db_host = 'mysql.cs.iastate.edu';
    $db_user = 'u309M13';
    $db_pass = 'T2GWRYDIw';
    $db_name = 'db309M13';

    $game_id = $values->get_Id_Game();
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);  
    foreach($board as $key => $value)
    {
        $game_id = $values->get_Id_Game();
        $row = $board_rep["board"][$i]["row"];
        $col = $board_rep["board"][$i]["col"];
        $piece = $board_rep["board"][$i]["piece"]
        $id = $board_rep["board"][$i]["id"]
        $sql1 = "INSERT INTO Square (row, col, enumeration, occupied_by, game_id)
                 VALUES ('$row', '$col','$piece','$id','$game_id')";
        $sql2 = "INSERT INTO Piece (row, col, piece_id, game_id)
                 VALUES ('$row', '$col','$id','$game_id')";
        $conn->query($sql1);
        $conn->query($sql2);
    }
/*    $sql3 = "SELECT * 
             FROM Piece
             WHERE piece_id > 199";
    $result = $conn->query($sql3);
    while ($row = $result->fetch_assoc())
    {
        $temp = getPotentialMoves($row["row"],$row["col"]);
        for($j = 0; $j < count($temp); $j++)
        {
            $sql4 = "INSERT INTO Moves(game_id, piece_id, to_row, to_col, occupied_by, from_row, from_col)
                     VALUES ('$values->get_Id_Game()','$row['piece_id']','$temp['to'][$j]['to_row'], '$temp['to'][$j]['to_col']', '$temp['to'][$j]['id']','$row['row']','$row['col']')";
            $conn->query($sql4);
        }*/
    }
    $conn->close();
    $my_array = array($client_username, $client_color, $opponent_username, $turn_number, $board_rep);
    echo json_encode($my_array);
?>