<?php
    $decoded = json_decode($_POST["data"],true);
    
    foreach($decoded as $value) {
        echo "Row: " .$value["row"] . "Column: " . $value["col"]; 
    }
?>