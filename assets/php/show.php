<?php
include_once("db_create.php");
include("db_connect.php");
if($_REQUEST["id"]==1){
    $fName = "andamentoNazionale";
    $url="";
    for($j=2;$j<=3;$j++){
        for($tmp=1;$tmp<=31;$tmp++)
        {
            if($j<10 && $tmp<10){
                $url = "https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-andamento-nazionale/dpc-covid19-ita-andamento-nazionale-2020" . "0" .$j. "0" .$tmp. ".csv";
            } else if ($j < 10) {
                $url = "https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-andamento-nazionale/dpc-covid19-ita-andamento-nazionale-2020" . "0" . $j . $tmp . ".csv";
            } else if ($tmp < 10) {
                $url = "https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-andamento-nazionale/dpc-covid19-ita-andamento-nazionale-2020" . $j  . "0" . $tmp . ".csv";
            }else{
                $url = "https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-andamento-nazionale/dpc-covid19-ita-andamento-nazionale-2020" . $j  . $tmp . ".csv";
            }
            include("downloader.php"); //scarica la risorsa dall'url immesso sopra
            //include("makeGraph.php"); //crea il grafico richiesto
        }
    }
}else{
    echo "Failed handling request with id:".$_REQUEST["id"];
}//gestire ulteriori richieste 


?>
