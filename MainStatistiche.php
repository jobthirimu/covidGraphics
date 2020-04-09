<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covid-Statistics</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <meta name="format-detection" content="telephone=no">
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link p-2 text-center" href="index.php" rel="noopener">
                        <i class="fas fa-home"></i>&nbspHome
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link p-2 text-center" href="#mondiali" rel="noopener">
                        <i class="fas fa-globe"></i>&nbspMondiali
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link p-2 text-center" href="#nazionali" rel="noopener">
                        <i class="fas fa-flag"></i>&nbspNazionali
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link p-2 text-center" href="#regionali" rel="noopener">
                        <i class="fas fa-location-arrow"></i>&nbspRegionali
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link p-2 text-center" href="#provinciali" rel="noopener">
                        <i class="fas fa-city"></i>&nbspProvinciali
                    </a>
                </li>
            </ul>
            <a class="nav-link p-2 text-center ml-auto" href="https://github.com/mzanrosso/covidGraphics" target="_blank" rel="noopener">
                <i style="color: #CCC" class="fab fa-github"></i>
            </a>
            <div class="dropdown-divider"></div>
            <form class="" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <div class="input-group">
                    <input type="hidden" name="cmd" value="_s-xclick" />
                    <input type="hidden" name="hosted_button_id" value="HPDFHTWTG7QCE" />
                    <input class="" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" title="Grazie per il tuo supporto!" alt="Fai una donazione con il pulsante PayPal" />
                    <img alt="" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1" />
                </div>
            </form>
        </div>
    </nav>
    <div class="jumbotron jumbotron-fluid p-10">
        <div class="container">
            <h1 class="display-4">Statistics Page</h1>
            <p class="lead">Il sito per le statistiche riguardanti il uovo coronavirus</p>
            <br>
            <hr class="my-1">
        </div>
        <!-- <p>Seleziona il servizio</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Grafici</a>
        <a class="btn btn-primary btn-lg" href="#" role="button">Statistice</a> -->
    </div>
    <?php
    include("assets/php/db_connect.php");
    $tmpSqlQuery = "SELECT COLUMN_NAME as c FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'id13002461_covid' AND TABLE_NAME ='time_series_covid19_confirmed_global' ORDER BY ORDINAL_POSITION DESC LIMIT 1";
    $nameLastColumn = $db->query($tmpSqlQuery)->fetch_assoc()["c"];
    $totCasi = $db->query("SELECT SUM($nameLastColumn) as num FROM time_series_covid19_confirmed_global")->fetch_assoc()["num"];
    $totGuariti = $db->query("SELECT SUM($nameLastColumn) as num FROM time_series_covid19_recovered_global")->fetch_assoc()["num"];
    $totMorti = $db->query("SELECT SUM($nameLastColumn) as num FROM time_series_covid19_deaths_global")->fetch_assoc()["num"];
    $totPositivi = $totCasi - $totGuariti - $totMorti;
    $positiviSuCasi = $totPositivi / $totCasi * 100;
    $guaritiSuCasi = $totGuariti / $totCasi * 100;
    $mortiSuCasi = $totMorti / $totCasi * 100;
    ?>
    <ul class="list-group">
        <h4 id="mondiali">Statistiche Mondiali</h4>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Totale dei casi
            <span class="badge badge-primary badge-pill"><?= number_format($totCasi, 0, '', ' ') ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Totale dei positivi
            <span class="badge badge-primary badge-pill"><?= number_format($totPositivi, 0, '', ' ') ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Totale dei guariti
            <span class="badge badge-primary badge-pill"><?= number_format($totGuariti, 0, '', ' ') ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Totale dei morti
            <span class="badge badge-primary badge-pill"><?= number_format($totMorti, 0, '', ' ') ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Percentuale positivi sul totale dei casi
            <span class="badge badge-primary badge-pill"><?= number_format($positiviSuCasi, 2, ',', ' ') . "%" ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Percentuale guariti sul totale dei casi
            <span class="badge badge-primary badge-pill"><?= number_format($guaritiSuCasi, 2, ',', ' ') . "%"  ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Percentuale morti sul totale dei casi
            <span class="badge badge-primary badge-pill"><?= number_format($mortiSuCasi, 2, ',', ' ') . "%"  ?></span>
        </li>
    </ul>
    <br>
    <?php
    $totCasi = $db->query("SELECT totale_casi as num FROM andamentoNazionale ORDER BY data desc LIMIT 1")->fetch_assoc()["num"];
    $totGuariti = $db->query("SELECT dimessi_guariti as num FROM andamentoNazionale ORDER BY data desc LIMIT 1")->fetch_assoc()["num"];
    $totMorti = $db->query("SELECT deceduti as num FROM andamentoNazionale ORDER BY data desc LIMIT 1")->fetch_assoc()["num"];
    $totPositivi = $totCasi - $totGuariti - $totMorti;
    $positiviSuCasi = $totPositivi / $totCasi * 100;
    $guaritiSuCasi = $totGuariti / $totCasi * 100;
    $mortiSuCasi = $totMorti / $totCasi * 100;
    ?>
    <ul class="list-group">
        <h4 id="nazionali">Statistiche Nazionali</h4>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Totale dei casi
            <span class="badge badge-primary badge-pill"><?= number_format($totCasi, 0, '', ' ') ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Totale dei positivi
            <span class="badge badge-primary badge-pill"><?= number_format($totPositivi, 0, '', ' ') ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Totale dei guariti
            <span class="badge badge-primary badge-pill"><?= number_format($totGuariti, 0, '', ' ') ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Totale dei morti
            <span class="badge badge-primary badge-pill"><?= number_format($totMorti, 0, '', ' ') ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Percentuale positivi sul totale dei casi
            <span class="badge badge-primary badge-pill"><?= number_format($positiviSuCasi, 2, ',', ' ') . "%" ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Percentuale guariti sul totale dei casi
            <span class="badge badge-primary badge-pill"><?= number_format($guaritiSuCasi, 2, ',', ' ') . "%"  ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Percentuale morti sul totale dei casi
            <span class="badge badge-primary badge-pill"><?= number_format($mortiSuCasi, 2, ',', ' ') . "%"  ?></span>
        </li>
    </ul>
    <br>
    <?php
    // $tmpSqlQuery = "SELECT COLUMN_NAME as c FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'id13002461_covid' AND TABLE_NAME ='time_series_covid19_confirmed_global' ORDER BY ORDINAL_POSITION DESC LIMIT 1";
    // $nameLastColumn = $db->query($tmpSqlQuery)->fetch_assoc()["c"];
    // $totCasi = $db->query("SELECT SUM($nameLastColumn) as num FROM time_series_covid19_confirmed_global")->fetch_assoc()["num"];
    // $totGuariti = $db->query("SELECT SUM($nameLastColumn) as num FROM time_series_covid19_recovered_global")->fetch_assoc()["num"];
    // $totMorti = $db->query("SELECT SUM($nameLastColumn) as num FROM time_series_covid19_deaths_global")->fetch_assoc()["num"];
    // $totPositivi = $totCasi - $totGuariti - $totMorti;
    // $positiviSuCasi = $totPositivi / $totCasi * 100;
    // $guaritiSuCasi = $totGuariti / $totCasi * 100;
    // $mortiSuCasi = $totMorti / $totCasi * 100;
    ?>
    <ul class="list-group">
        <h4 id="regionali">Statistiche Regionali</h4>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Test
            <span class="badge badge-primary badge-pill">X</span>
        </li>
    </ul>
    <br>
    <?php
    // $tmpSqlQuery = "SELECT COLUMN_NAME as c FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'id13002461_covid' AND TABLE_NAME ='time_series_covid19_confirmed_global' ORDER BY ORDINAL_POSITION DESC LIMIT 1";
    // $nameLastColumn = $db->query($tmpSqlQuery)->fetch_assoc()["c"];
    // $totCasi = $db->query("SELECT SUM($nameLastColumn) as num FROM time_series_covid19_confirmed_global")->fetch_assoc()["num"];
    // $totGuariti = $db->query("SELECT SUM($nameLastColumn) as num FROM time_series_covid19_recovered_global")->fetch_assoc()["num"];
    // $totMorti = $db->query("SELECT SUM($nameLastColumn) as num FROM time_series_covid19_deaths_global")->fetch_assoc()["num"];
    // $totPositivi = $totCasi - $totGuariti - $totMorti;
    // $positiviSuCasi = $totPositivi / $totCasi * 100;
    // $guaritiSuCasi = $totGuariti / $totCasi * 100;
    // $mortiSuCasi = $totMorti / $totCasi * 100;
    ?>
    <ul class="list-group">
        <h4 id="provinciali">Statistiche Provinciali</h4>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            test
            <span class="badge badge-primary badge-pill">X</span>
        </li>
    </ul>
    <footer class="page-footer font-small blue pt-4">
        <div class="footer-copyright text-center py-3">
            Created by Marco Zanrosso©
        </div>
    </footer>
    <script src="https://kit.fontawesome.com/6451ae53a9.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>