<?php

//error_reporting(E_ERROR | E_PARSE);
require_once("../framework/pChart2.1.4/class/pDraw.class.php");
require_once("../framework/pChart2.1.4/class/pImage.class.php");
require_once("../framework/pChart2.1.4/class/pData.class.php");

$sql = "SELECT * FROM $fName";
$result  = $db->query($sql);
$campi="";
while ($row = $result->fetch_assoc()) {
    foreach($row as $key=>$value){
        //$campi[] = $row[$key];
        //code
    }
}

if ($_REQUEST["id"] == 1) { 
} {
    echo "<br><br>Failed making graph with id:" . $_REQUEST["id"];
} //gestire ulteriori richieste 

?>