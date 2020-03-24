<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Covid Graphics</title>
    <link rel="stylesheet" href="assets/css/Main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
</head>

<body>
    <nav id="head">
        <div id="1">Aggiorna DB</div>
        <div id="2" strY="totale_casi" lbl="Totale dei casi" type="bar">Totale Casi</div>
        <div id="3" strY="totale_attualmente_positivi" lbl="Totale Infetti">Totale Infetti</div>
        <div id="4" strY="nuovi_attualmente_positivi" lbl="Nuovi Infetti">Nuovi Infetti</div>
        <div id="5" strY="dimessi_guariti" lbl="Totale Guariti">Totale Guariti</div>
        <div id="6" strY="deceduti" lbl="Totale Morti">Totale Morti</div>
    </nav>
    <nav id="subnav">

    </nav>
    <div class="contenitore" id="bm">
    </div>
    <div id="chart-container">
        <canvas id="graphCanvas"></canvas>
    </div>
    <footer>

    </footer>
    <script src="assets/js/Main.js"></script>
</body>

</html>