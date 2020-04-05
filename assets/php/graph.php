<?php
header('Content-Type: application/json');
require_once("db_connect.php");

$choose1 = $_REQUEST["choose1"];
$choose2 = $_REQUEST["choose2"];
$input = $_REQUEST["input"];
$sqlQuery = "";
$result = "";
//echo $choose2;
$agg = 0;
$strY = "";
$tableName="";
switch ($choose1) {
    case "Mondiale": {
            if ($input == "err") {
                switch ($choose2) {
                    case "Totale Casi":
                        $strY = "totale_casi";
                        $tableName= "time_series_covid19_confirmed_global";
                        break;
                    case "Totale Guariti":
                        $strY = "dimessi_guariti";
                        $tableName = "time_series_covid19_recovered_global";
                        break;
                    case "Totale Morti":
                        $strY = "deceduti";
                        $tableName = "time_series_covid19_deaths_global";
                        break;
                }
                $tmpSqlQuery= "SELECT COLUMN_NAME as c FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'id13002461_covid' AND TABLE_NAME ='time_series_covid19_confirmed_global' ORDER BY ORDINAL_POSITION DESC LIMIT 1";
                $nameLastColumn=$db->query($tmpSqlQuery)->fetch_assoc()["c"];
                $sqlQuery="SELECT * FROM $tableName ORDER BY cast($nameLastColumn  as int) DESC limit 30";
                $result= $db->query($sqlQuery);
            }else{
                switch ($choose2) {
                    case "Totale Casi":
                        $strY = "totale_casi";
                        $tableName = "time_series_covid19_confirmed_global";
                        break;
                    case "Totale Guariti":
                        $strY = "dimessi_guariti";
                        $tableName = "time_series_covid19_recovered_global";
                        break;
                    case "Totale Morti":
                        $strY = "deceduti";
                        $tableName = "time_series_covid19_deaths_global";
                        break;
                }
                $sqlQuery = "SELECT * FROM $tableName WHERE country_region LIKE '$input%'";
                $result = $db->query($sqlQuery);
            }
            if($result->num_rows>1){
                $agg= $result->num_rows;
            }else if($result->num_rows==1){
                $agg=0;
            }else{
                echo "<br>$sqlQuery<br>";
                echo "Errore query mondiale nulla num:". $db->query($sqlQuery)->num_rows;
            }
        };
        break;
    case "Nazionale": {
            if ($choose2 == "Nuovi Morti") {
                $sqlQuery = "SELECT a1.*,(a1.deceduti -(
                        SELECT a2.deceduti
                        FROM andamentoNazionale AS a2
                        WHERE a2.id = a1.id-1
                    )
                ) as nuovi_deceduti 
                FROM andamentoNazionale AS a1";
            }else if($choose2 == "Nuovi Guariti"){
                $sqlQuery = "SELECT a1.*,(a1.dimessi_guariti -(
                        SELECT a2.dimessi_guariti
                        FROM andamentoNazionale AS a2
                        WHERE a2.id = a1.id-1
                    )
                ) as nuovi_dimessi_guariti 
                FROM andamentoNazionale AS a1";
            } else if ($choose2 == "Nuovi Tamponi") {
                $sqlQuery = "SELECT a1.*,(a1.tamponi -(
                        SELECT a2.tamponi
                        FROM andamentoNazionale AS a2
                        WHERE a2.id = a1.id-1
                    )
                ) as nuovi_tamponi
                FROM andamentoNazionale AS a1";
            } else {
                $sqlQuery = "SELECT * FROM andamentoNazionale";
            }
            $result = mysqli_query($db, $sqlQuery);
        };
        break;
    case "Regionale": {
            if ($input == "err") {
                switch ($choose2) {
                    case "Totale Casi":
                        $strY = "totale_casi";
                        break;
                    case "Totale Positivi":
                        $strY = "totale_positivi";
                        break;
                    case "Variazione Totale Positivi":
                        $strY = "variazione_totale_positivi";
                        break;
                    case "Nuovi Positivi":
                        $strY = "nuovi_positivi";
                        break;
                    case "Totale Guariti":
                        $strY = "dimessi_guariti";
                        break;
                    case "Totale Morti":
                        $strY = "deceduti";
                        break;
                    case "Totale Tamponi":
                        $strY = "tamponi";
                        break;
                }
                if ($choose2 == "Nuovi Morti") {
                    $sqlQuery = "SELECT a1.denominazione_regione,a1.data,(a1.deceduti -(
                            SELECT a2.deceduti
                            FROM andamentoRegionale AS a2
                            WHERE a2.id = a1.id-21
                        )
                    ) as nuovi_deceduti 
                    FROM andamentoRegionale AS a1
                    GROUP BY denominazione_regione,data";
                } else if ($choose2 == "Nuovi Guariti") {
                    $sqlQuery = "SELECT a1.denominazione_regione,a1.data,(a1.dimessi_guariti -(
                            SELECT a2.dimessi_guariti
                            FROM andamentoRegionale AS a2
                            WHERE a2.id = a1.id-21
                        )
                    ) as nuovi_dimessi_guariti 
                    FROM andamentoRegionale AS a1
                    GROUP BY denominazione_regione,data";
                } else if ($choose2 == "Nuovi Tamponi") {
                    $sqlQuery = "SELECT a1.denominazione_regione,a1.data,(a1.tamponi -(
                            SELECT a2.tamponi
                            FROM andamentoRegionale AS a2
                            WHERE a2.id = a1.id-21
                        )
                    ) as nuovi_tamponi
                    FROM andamentoRegionale AS a1
                    GROUP BY denominazione_regione,data";
                } else {
                    $sqlQuery = "SELECT denominazione_regione,data," . $strY . " FROM andamentoRegionale GROUP BY denominazione_regione,data";
                }
                $agg = $db->query("SELECT count(*) as num FROM andamentoRegionale")->fetch_assoc()["num"];
                $agg /= 21;
            } else {
                if ($choose2 == "Nuovi Morti") {
                    $sqlQuery = "SELECT a1.*,(a1.deceduti -(
                            SELECT a2.deceduti
                            FROM andamentoRegionale AS a2
                            WHERE a2.id = a1.id-21 && denominazione_regione LIKE '$input'
                        )
                    ) as nuovi_deceduti 
                    FROM andamentoRegionale AS a1
                    WHERE denominazione_regione LIKE '$input'";
                } else if ($choose2 == "Nuovi Guariti") {
                    $sqlQuery = "SELECT a1.*,(a1.dimessi_guariti -(
                            SELECT a2.dimessi_guariti
                            FROM andamentoRegionale AS a2
                            WHERE a2.id = a1.id-21 && denominazione_regione LIKE '$input'
                        )
                    ) as nuovi_dimessi_guariti 
                    FROM andamentoRegionale AS a1
                    WHERE denominazione_regione LIKE '$input'";
                    
                } else if ($choose2 == "Nuovi Tamponi") {
                    $sqlQuery = "SELECT a1.*,(a1.tamponi -(
                            SELECT a2.tamponi
                            FROM andamentoRegionale AS a2
                            WHERE a2.id = a1.id-21 && denominazione_regione LIKE '$input' 
                        )
                    ) as nuovi_tamponi
                    FROM andamentoRegionale AS a1
                    WHERE denominazione_regione LIKE '$input'";
                } else {
                    $sqlQuery = "SELECT * FROM andamentoRegionale WHERE denominazione_regione LIKE '" . $input . "'";
                }
            }
            $result = mysqli_query($db, $sqlQuery);
        };
        break;
    case "Provinciale": {
            if ($input == "err") {
                switch ($choose2) {
                    case "Totale Casi":
                        $strY = "totale_casi";
                        break;
                    case "Totale Positivi":
                        $strY = "totale_positivi";
                        break;
                    case "Variazione Totale Positivi":
                        $strY = "variazione_totale_positivi";
                        break;
                    case "Nuovi Positivi":
                        $strY = "nuovi_positivi";
                        break;
                    case "Totale Guariti":
                        $strY = "dimessi_guariti";
                        break;
                    case "Totale Morti":
                        $strY = "deceduti";
                        break;
                    case "Totale Tamponi":
                        $strY = "tamponi";
                        break;
                }
                $sqlQuery = "SELECT denominazione_provincia,data," . $strY . " FROM andamentoProvinciale GROUP BY denominazione_provincia,data";
                $agg = $db->query("SELECT count(*) as num FROM andamentoProvinciale")->fetch_assoc()["num"];
                $agg /= 128;
            } else {
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
                    "abruzzo" => 5,
                    "basilicata" => 3,
                    "p.a. bolzano" => 2,
                    "calabria" => 6,
                    "campania" => 6,
                    "emilia romagna" => 10,
                    "friuli venezia giulia" => 5,
                    "lazio" => 6,
                    "liguria" => 5,
                    "lombardia" => 13,
                    "marche" => 6,
                    "molise" => 3,
                    "piemonte" => 9,
                    "puglia" => 7,
                    "sardegna" => 6,
                    "sicilia" => 10,
                    "toscana" => 11,
                    "p.a. trento" => 2,
                    "umbria" => 3,
                    "valle d'aosta" => 2,
                    "veneto" => 8
                );
                if (in_array(strtolower($input), $regioni)) {
                    $sqlQuery = "SELECT * FROM andamentoProvinciale WHERE denominazione_regione LIKE '$input' GROUP BY denominazione_provincia,data";
                    $agg = $db->query("SELECT count(*) as num FROM andamentoProvinciale WHERE denominazione_regione LIKE '$input'")->fetch_assoc()["num"];
                    $agg /= $provincesuregioni[strtolower($input)];
                } else {
                    $sqlQuery = "SELECT * FROM andamentoProvinciale WHERE denominazione_provincia LIKE '" . $input . "'";
                }
            }
            $result = mysqli_query($db, $sqlQuery);
        };
        break;
    case "Comunale": {
        };
        break;
}

$data = array();
if (is_array($result) || is_object($result)) {
    foreach ($result as $row) {
        $data[] = $row;
    }
}

echo json_encode($data);
echo $agg != 0 ? "£" . $agg : "£";
