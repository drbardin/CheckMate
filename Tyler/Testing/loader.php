<?php
//Test the POST: Result is emptyness
    var_dump( $_POST['data']);

//Test the JSON return: Result is a correct JSON with null property values
/*    $myJson = json_decode($_POST['data'], true);
    $myJson->row;
    $myJson->col;
    $newarray = array(
        "row" => $myJson->row,
        "col" => $myJson->col
    );
    header('Content-Type: application/json');
    echo json_encode($newarray);
*/



//Test the property value returns: Result is weird and confusing. 
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

?>