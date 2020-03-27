<?php
header('Content-Type: application/json');
require_once("db_connect.php");

$choose1=$_REQUEST["choose1"];
$choose2 = $_REQUEST["choose2"];
$input = $_REQUEST["input"];
$sqlQuery ="";
$result="";
//echo $choose2;
switch ($choose1) {
        case "Mondiale": {
        };break;
        case "Nazionale": {
            if($choose2 != "Confronto"){
                $sqlQuery="SELECT * FROM andamentoNazionale";
            }else{
                $sqlQuery = "SELECT denominazione_regione,data,totale_casi FROM andamentoRegionale GROUP BY denominazione_regione,data";
            }
            $result = mysqli_query($db, $sqlQuery);
        };break;
        case "Regionale": {
            if ($choose2 != "Confronto") {
                $sqlQuery = "SELECT * FROM andamentoRegionale WHERE denominazione_regione LIKE '".$input."'";
            } else {
                $sqlQuery = "SELECT denominazione_regione,data,totale_casi FROM andamentoRegionale GROUP BY denominazione_regione,data";
            }
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
