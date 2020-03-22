<?php

//error_reporting(E_ERROR | E_PARSE);
require_once("db_connect.php");

// $sql = "SELECT * FROM $fName";
// $result  = $db->query($sql);
// $campi="";
// while ($row = $result->fetch_assoc()) {
//     foreach($row as $key=>$value){
//         //$campi[] = $row[$key];
//         //code
//     }
// }

header('Content-Type: application/json');
$sqlQuery = "SELECT * FROM andamentoNazionale";
$result = mysqli_query($db, $sqlQuery);
$data = array();
foreach ($result as $row) {
    $data[] = $row;
}
echo json_encode($data);


?>