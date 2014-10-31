<?php
    $decoded = json_decode($_POST["data"],true);
    if ($decoded->row>=0){
        echo "Awesome";
    }
    else
    {
        echo "bad";
    }
//    echo json_encode(var_dump(json_decode($_POST["data"],true)));
  //  $decoded = json_decode($_POST["data"], true);
/*    foreach($decoded as $key=>$value) {
        echo $key . '=' . $value;
    }*/

  //  header('Content-Type: application/json');
// echo json_encode($decoded);
?>