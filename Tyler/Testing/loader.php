<?php
    $myJson = json_decode($_POST['data'], true);
    $MyJson->row;
    $MyJson->col;
    $newarray = array("row"=>$row,"col"=>$col);
    echo json_encode($newarray);
/*    $decoded = json_decode($_POST["data"], true);
    ////var_dump is causing issues
    $r = $decoded['row'];
    $c = $decoded['col'];
    $num = 4;
    if ($decoded->row>=0){
        foreach ($decoded AS $prop => $val)
        {
            echo $prop . " " . $val;
        }
        echo $r . " " . $c . " " . $num;
    }
    else
    {
        echo "bad";
    }*/

  //  header('Content-Type: application/json');
// echo json_encode($decoded);
?>