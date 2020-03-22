<?php
if($_REQUEST["id"]==1){
    $url= "https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-andamento-nazionale/dpc-covid19-ita-andamento-nazionale-latest.csv";
    include_once("downloader.php"); //scarica la risorsa dall'url immesso sopra
    include_once("makeGraph.php"); //crea il grafico richiesto
}else{
    echo "Failed handling request with id:".$_REQUEST["id"];
}//gestire ulteriori richieste 


?>
