<?php
header('Content-Type: application/json');
require_once("db_connect.php");

$choose1=$_REQUEST["choose1"];
$input = $_REQUEST["input"];
$sqlQuery ="";
$result="";
switch ($choose1) {
        case "Mondiale": {
        };break;
        case "Nazionale": {
            $sqlQuery="SELECT * FROM andamentoNazionale";
            $result = mysqli_query($db, $sqlQuery);
        };break;
        case "Regionale": {
            $sqlQuery = "SELECT * FROM andamentoRegionale WHERE denominazione_regione LIKE '".$input."'";
            $result = mysqli_query($db, $sqlQuery);
        };break;
        case "Provinciale": {
            $sqlQuery = "SELECT * FROM andamentoProvinciale WHERE denominazione_provincia LIKE '" . $input . "'";
            $result = mysqli_query($db, $sqlQuery);
        };break;
        case "Comunale": {};break;
    }

$data = array();
if (is_array($result) || is_object($result)){
    foreach ($result as $row) {
        $data[] = $row;
    }
}
echo json_encode($data);
