<?php
header('Content-Type: application/json');
require_once("db_connect.php");

$choose1=$_REQUEST["choose1"];
$choose2 = $_REQUEST["choose2"];
$input = $_REQUEST["input"];
$sqlQuery ="";
$result="";
//echo $choose2;
$agg=0;
$strY="";
switch ($choose1) {
        case "Mondiale": {
        };break;
        case "Nazionale": {
            $sqlQuery="SELECT * FROM andamentoNazionale";
            $result = mysqli_query($db, $sqlQuery);
        };break;
        case "Regionale": {
            if ($input == "err") {
                switch ($choose2) {
                    case "Totale Casi":
                        $strY = "totale_casi";
                        break;
                    case "Totale Attualmente Infetti":
                        $strY = "totale_attualmente_positivi";
                        break;
                    case "Nuovi Infetti":
                        $strY = "nuovi_attualmente_positivi";
                        break;
                    case "Totale Guariti":
                        $strY = "dimessi_guariti";
                        break;
                    case "Totale Morti":
                        $strY = "deceduti";
                        break;
                }
                $sqlQuery = "SELECT denominazione_regione,data," . $strY . " FROM andamentoRegionale GROUP BY denominazione_regione,data";
                $agg = $db->query("SELECT count(*) as num FROM andamentoRegionale")->fetch_assoc()["num"];
                $agg /= 21;
            } else {
                $sqlQuery = "SELECT * FROM andamentoRegionale WHERE denominazione_regione LIKE '" . $input . "'";
            }
            $result = mysqli_query($db, $sqlQuery);
        };break;
        case "Provinciale": {
            if ($input == "err") {
                switch ($choose2) {
                    case "Totale Casi":
                        $strY = "totale_casi";
                        break;
                    case "Totale Attualmente Infetti":
                        $strY = "totale_attualmente_positivi";
                        break;
                    case "Nuovi Infetti":
                        $strY = "nuovi_attualmente_positivi";
                        break;
                    case "Totale Guariti":
                        $strY = "dimessi_guariti";
                        break;
                    case "Totale Morti":
                        $strY = "deceduti";
                        break;
                }
                $sqlQuery = "SELECT denominazione_provincia,data," . $strY . " FROM andamentoProvinciale GROUP BY denominazione_provincia,data";
                $agg = $db->query("SELECT count(*) as num FROM andamentoProvinciale")->fetch_assoc()["num"];
                $agg /= 128;
            }else{
                $sqlQuery = "SELECT * FROM andamentoProvinciale WHERE denominazione_provincia LIKE '" . $input . "'";
            }
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
echo $agg != 0 ? "£".$agg: "";
