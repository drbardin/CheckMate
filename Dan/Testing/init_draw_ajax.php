<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include_once "classGame.php";
include_once "classPiece.php";
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
    {
        echo "THIS IS NOT RIGHT....BAD CODE!..VERY BAD.";
    }
/*           $board_rep = array("board"=>array(array("piece"=> 3,"row"=>0,"col"=> 0,"status"=>true,"id"=> 110)),
                                array(array("piece"=> 1, "row"=> 0, "col"=> 1, "status"=> true, "id"=>120)),
                                array(array("piece"=> 2, "row"=> 0, "col"=>2, "status"=> true, "id"=>130)),
                                array(array("piece"=> 5, "row"=>0, "col"=>3, "status"=> true, "id"=>140)),
                                array(array("piece"=> 4, "row"=>0, "col"=>4, "status"=> true, "id"=>150)),
                                array(array("piece"=>2, "row"=>0, "col"=>5, "status"=> true, "id"=>131)),
                                array(array("piece"=>1, "row"=>0, "col"=>6, "status"=> true, "id"=>121)),
                                array(array("piece"=>3,  "row"=> 0, "col"=>7, "status"=> true, "id"=>111)),
                                array(array("piece"=>0,  "row"=>1, "col"=>0, "status"=> true, "id"=>100)),
                                array(array("piece"=>0,  "row"=>1, "col"=>1, "status"=> true, "id"=>101)),
                                array(array("piece"=>0,  "row"=>1, "col"=>2, "status"=> true, "id"=>102)),
                                array(array("piece"=>0,  "row"=>1, "col"=>3, "status"=>true, "id"=>103)),
                                array(array("piece"=>0,  "row"=>1, "col"=>4, "status"=>true, "id"=>104)),
                                array(array("piece"=>0,  "row"=>1, "col"=>5, "status"=>true, "id"=>105)),
                                array(array("piece"=>0,  "row"=>1, "col"=>6, "status"=>true, "id"=>106)),
                                array(array("piece"=>0,  "row"=>1, "col"=>7, "status"=>true, "id"=>107)),
                                array(array("piece"=>-1, "row"=>2, "col"=>0, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>2, "col"=>1, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>2, "col"=>2, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>2, "col"=>3, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>2, "col"=>4, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>2, "col"=>5, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>2, "col"=>6, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>2, "col"=>7, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>3, "col"=>0, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>3, "col"=>1, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>3, "col"=>2, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>3, "col"=>3, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>3, "col"=>4, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>3, "col"=>5, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>3, "col"=>6, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>3, "col"=>7, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>4, "col"=>0, "status"=>true, "id"=>0 )),
                                array(array("piece"=>-1, "row"=>4, "col"=>1, "status"=>true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>4, "col"=>2, "status"=> true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>4, "col"=>3, "status"=>true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>4, "col"=>4, "status"=>true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>4, "col"=>5, "status"=>true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>4, "col"=>6, "status"=>true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>4, "col"=>7, "status"=>true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>5, "col"=>0, "status"=>true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>5, "col"=>1, "status"=>true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>5, "col"=>2, "status"=>true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>5, "col"=>3, "status"=>true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>5, "col"=>4, "status"=>true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>5, "col"=>5, "status"=>true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>5, "col"=>6, "status"=> true, "id"=>0 )),
                                array(array( "piece"=>-1, "row"=>5, "col"=>7, "status"=> true, "id"=>0 )),
                                array(array( "piece"=>0,  "row"=>6, "col"=>0, "status"=> true, "id"=>200 )),
                                array(array( "piece"=>0,  "row"=>6, "col"=>1, "status"=> true, "id"=>201 )),
                                array(array( "piece"=>0,  "row"=>6, "col"=>2, "status"=> true, "id"=>202 )),
                                array(array( "piece"=>0,  "row"=>6, "col"=>3, "status"=> true, "id"=>203 )),
                                array(array( "piece"=>0,  "row"=>6, "col"=>4, "status"=> true, "id"=>204 )),
                                array(array( "piece"=>0,  "row"=>6, "col"=>5, "status"=> true, "id"=>205 )),
                                array(array( "piece"=>0,  "row"=>6, "col"=>6, "status"=> true, "id"=>206 )),
                                array(array( "piece"=>0,  "row"=>6, "col"=>7, "status"=> true, "id"=>207 )),
                                array(array( "piece"=>3,  "row"=>7, "col"=>0, "status"=> true, "id"=>210 )),
                                array(array( "piece"=>1, "row"=>7, "col"=>1, "status"=> true, "id"=>220 )),
                                array(array( "piece"=>2, "row"=>7, "col"=>2, "status"=> true, "id"=>230 )),
                                array(array( "piece"=>5,  "row"=>7, "col"=>3, "status"=> true, "id"=>240 )),
                                array(array( "piece"=>4, "row"=>7, "col"=>4, "status"=> true, "id"=>250 )),
                                array(array( "piece"=>2, "row"=>7, "col"=>5, "status"=> true, "id"=>231 )),
                                array(array( "piece"=>1, "row"=>7, "col"=>6, "status"=> true, "id"=>221 )),
                                array(array( "piece"=>3,  "row"=>7, "col"=> 7, "status"=> true, "id"=>211 )));*/
    $board_rep = unserialize($board_rep);
/*    $db_host = 'mysql.cs.iastate.edu';
    $db_user = 'u309M13';
    $db_pass = 'T2GWRYDIw';
    $db_name = 'db309M13';

    //Create connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);  
    for ($i = 0; $i < count($board_rep);$i++)
    {
        $sql1 = "INSERT INTO Square (row, col, enumeration, occupied_by, game_id)
                VALUES ('$board_rep["board"][$i]["row"]', '$board_rep["board"][$i]["col"]','$board_rep["board"][$i]["piece"]','$board_rep["board"][$i]["id"]','$values->get_Id_Game()')";
        $sql2 = "INSERT INTO Piece (row, col, piece_id, game_id)
                VALUES ('$board_rep["board"][$i]["row"]', '$board_rep["board"][$i]["col"]','$board_rep["board"][$i]["id"]','$values->get_Id_Game()')";
        $conn->query($sql1);
        $conn->query($sql2);
    }
    $sql3 = "SELECT * 
             FROM Piece
             WHERE piece_id > 199";
    $result = $conn->query($sql3);
    while ($row = $result->fetch_association())
    {
        $temp = getPotentialMoves($row["row"],$row["col"]);
        for($j = 0; $j < count($temp); $j++)
        {
            $sql4 = "INSERT INTO Moves(game_id, piece_id, to_row, to_col, occupied_by, from_row, from_col)
                     VALUES ('$values->get_Id_Game()','$row["piece_id"]','$temp["to"][$j]["to_row"], '$temp["to"][$j]["to_col"]', '$temp["to"][$j]["id"]','$row["row"]','$row["col"]')";
        }
    }
    $conn->close();*/
    $my_array = array($client_username, $client_color, $opponent_username, $turn_number, $board_rep);
    echo json_encode($my_array);
?>