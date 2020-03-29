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
            if($choose2=="Nuovi Morti"){
                $sqlQuery = "SELECT a1.*,(a1.deceduti -(
                        SELECT a2.deceduti
                        FROM andamentoNazionale AS a2
                        WHERE a2.id = a1.id-1
                    )
                ) as nuovi_deceduti 
                FROM andamentoNazionale AS a1" ;
            }else{
                $sqlQuery = "SELECT * FROM andamentoNazionale";
            }
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
                if($choose2=="Nuovi Morti"){
                    $sqlQuery = "SELECT a1.*,(a1.deceduti -(
                            SELECT a2.deceduti
                            FROM andamentoRegionale AS a2
                            WHERE a2.id = a1.id-21 && denominazione_regione LIKE '$input'
                        )
                    ) as nuovi_deceduti 
                    FROM andamentoRegionale AS a1
                    WHERE denominazione_regione LIKE '$input'";
                }else{
                    $sqlQuery = "SELECT * FROM andamentoRegionale WHERE denominazione_regione LIKE '" . $input . "'";
                }
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
                $regioni = array(
                    "abruzzo" => "abruzzo",
                    "basilicata" => "basilicata",
                    "p.a. bolzano" => "p.a. bolzano",
                    "calabria" => "calabria",
                    "campania" => "campania",
                    "emilia romagna" => "emilia romagna",
                    "friuli venezia giulia" => "friuli venezia giulia",
                    "lazio" => "lazio",
                    "liguria" => "liguria",
                    "lombardia" => "lombardia",
                    "marche" => "marche",
                    "molise" => "molise",
                    "piemonte" => "piemonte",
                    "puglia" => "puglia",
                    "sardegna" => "sardegna",
                    "sicilia" => "sicilia",
                    "toscana" => "toscana",
                    "p.a. trento" => "p.a. trento",
                    "umbria" => "umbria",
                    "valle d'aosta" => "valle d'aosta",
                    "veneto" => "veneto"
                );
                $provincesuregioni = array(
                    "abruzzo"=> 5,
                    "basilicata"=> 3,
                    "p.a. bolzano"=> 2,
                    "calabria"=> 6,
                    "campania"=> 6,
                    "emilia romagna"=> 10,
                    "friuli venezia giulia"=> 5,
                    "lazio"=> 6,
                    "liguria"=> 5,
                    "lombardia"=> 13,
                    "marche"=> 6,
                    "molise"=> 3,
                    "piemonte"=> 9,
                    "puglia"=> 7,
                    "sardegna"=> 6,
                    "sicilia"=> 10,
                    "toscana"=> 11,
                    "p.a. trento"=> 2,
                    "umbria"=> 3,
                    "valle d'aosta"=> 2,
                    "veneto"=> 8
                );
                if(in_array(strtolower($input),$regioni)){
                    $sqlQuery = "SELECT * FROM andamentoProvinciale WHERE denominazione_regione LIKE '$input' ORDER BY denominazione_provincia";
                    $agg = $db->query("SELECT count(*) as num FROM andamentoProvinciale WHERE denominazione_regione LIKE '$input'")->fetch_assoc()["num"];
                    $agg /= $provincesuregioni[strtolower($input)];
                }else{
                    $sqlQuery = "SELECT * FROM andamentoProvinciale WHERE denominazione_provincia LIKE '" . $input . "'";
                }
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
