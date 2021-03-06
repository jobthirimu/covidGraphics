<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>updater</title>
</head>
<body>
    <?php
   $richiesta= $_REQUEST["id"];

    //error_reporting(E_ERROR | E_PARSE);
    include_once("db_create.php");
    include("db_connect.php");
    $updated= 0;
    $fName = "";
    $url = "";
    $limit2 = date('m', time());
    
    switch($richiesta){
        case "mon": updateMon();break;
        case "naz": updateNaz();break;
        case "reg": updateReg();break;
        case "prov": updateProv();break;
        case "ita": updateIta();break;
        default : updateAll();
    }
    
    function updateMon()
    {
        $limit2 = date('m', time());
        $limit1 = $limit2 >= 2 ? $limit2 - 2 : 1;
        $fName = "andamentoMondiale";
        $url = "https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_time_series/time_series_covid19_confirmed_global.csv";
        unlink('../data/' . $fName . "/" . basename($url)); //elimino i dati precedenti
        include("downloader.php"); //scarico la risorsa

        $fName = "andamentoMondiale";
        $url = "https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_time_series/time_series_covid19_recovered_global.csv";
        unlink('../data/' . $fName . "/" . basename($url)); //elimino i dati precedenti
        include("downloader.php"); //scarico la risorsa

        $fName = "andamentoMondiale";
        $url = "https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_time_series/time_series_covid19_deaths_global.csv";
        unlink('../data/' . $fName . "/" . basename($url)); //elimino i dati precedenti
        include("downloader.php"); //scarico la risorsa

        //SELECT t1.* FROM `time_series_covid19_confirmed_global.csv` as t1 WHERE t1.lat NOT IN (SELECT t2.lat FROM `time_series_covid19_recovered_global.csv` as t2)
    }
    function updateNaz(){
        $limit2 = date('m', time());
        $limit1 = $limit2 >= 2 ? $limit2 - 2 : 1;
        $fName = "andamentoNazionale";
        $urlT= "https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-andamento-nazionale/dpc-covid19-ita-andamento-nazionale-";
        for ($m = $limit1; $m <= $limit2; $m++) {
            for ($g = 1; $g <= 31; $g++) {
                $d = mktime(0, 0, 0, $m, $g, 2020);
                $url=$urlT.date("Ymd", $d).".csv";
                if (!file_exists('../data/' . $fName . "/" . basename($url))) {
                    //echo "<br>" . $url;
                    include("downloader.php"); //scarico la risorsa
                }
                //echo "<script>console.log('Naz: m:" . $m . " g:" . $g . "')</script>";
            }
        }
    }
    function updateReg(){
        $limit2 = date('m', time());
        $limit1 = $limit2 >= 2 ? $limit2 - 2 : 1;
        $fName = "andamentoRegionale";
        $urlT = "https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-regioni/dpc-covid19-ita-regioni-";
        for ($m = $limit1; $m <= $limit2; $m++) {
            for ($g = 1; $g <= 31; $g++) {
                $d = mktime(0, 0, 0, $m, $g, 2020);
                $url = $urlT . date("Ymd", $d) . ".csv";
                if (!file_exists('../data/' . $fName . "/" . basename($url))) {
                    include("downloader.php"); //scarico la risorsa
                }
                //echo "<script>console.log('Reg: m:".$m." g:".$g."')</script>";
            }
        }
    }
    function updateProv(){
        $limit2 = date('m', time());
        $limit1 = $limit2 >= 2 ? $limit2 - 2 : 1;
        $fName = "andamentoProvinciale";
        $urlT = "https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-province/dpc-covid19-ita-province-";
        for ($m = $limit1; $m <= $limit2; $m++) {
            for ($g = 1; $g <= 31; $g++) {
                $d = mktime(0, 0, 0, $m, $g, 2020);
                $url = $urlT . date("Ymd", $d) . ".csv";
                if (!file_exists('../data/' . $fName . "/" . basename($url))) {
                    include("downloader.php"); //scarico la risorsa
                }
                //echo "<script>console.log('Prov: m:" . $m . " g:" . $g . "')</script>";
            }
        }
    }
    function updateIta(){
        updateNaz();
        updateReg();
        updateProv();
    }
    function updateAll(){
        updateMon();
        updateNaz();
        updateReg();
        updateProv();
    }
    
    if($updated==0){
        echo "<br>Tutto aggiornato";
    }else{
        echo "<br><br>Aggiornati: ".$updated;
    }
?>
</body>
</html>