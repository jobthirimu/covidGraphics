<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covid-Statistics</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <meta name="format-detection" content="telephone=no">
    <style>
        @media (max-width: 768px) {
            #github {
                margin: auto;
            }

            #paypal {
                margin: auto;
            }
        }

        @media (min-width: 768px) and (max-width: 992px) {
            #github {
                margin: auto;
            }

            #paypal {
                margin: auto;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav w-100">
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
                <li class="nav-item"><input id="input1" name="limitTop" type="number" class="form-control" placeholder="filtro top, default=10"></li>
                <form class="form-inline ml-2 my-2 my-lg-0">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="button">Modifica Top</button>
                </form>
                <li class="nav-item ml-auto" id="github">
                    <a class="nav-link p-2 text-center" href="https://github.com/mzanrosso/covidGraphics" target="_blank" rel="noopener">
                        <i style="color: #CCC" class="fab fa-github"></i>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item" id="paypal">
                    <a href="" class="nav-link">
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <div class="input-group">
                                <input type="hidden" name="cmd" value="_s-xclick" />
                                <input type="hidden" name="hosted_button_id" value="HPDFHTWTG7QCE" />
                                <input class="" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" title="Grazie per il tuo supporto!" alt="Fai una donazione con il pulsante PayPal" />
                                <img alt="" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1" />
                            </div>
                        </form>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="jumbotron jumbotron-fluid p-10">
        <div class="container">
            <h1 class="display-4">Statistics Page</h1>
            <p class="lead">Il sito per le statistiche riguardanti il nuovo coronavirus</p>
            <br>
            <hr class="my-1">
        </div>
    </div>
    <?php
    include("assets/php/db_connect.php");
    $numOfTop = !empty($_REQUEST["limitTop"]) ? $_REQUEST["limitTop"] : 3;
    $tmpSqlQuery = "SELECT COLUMN_NAME as c FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'id13002461_covid' AND TABLE_NAME ='time_series_covid19_confirmed_global' ORDER BY ORDINAL_POSITION DESC LIMIT 2";
    $result = $db->query($tmpSqlQuery);
    $nameLastColumn;
    $nameLastSecondColumn;
    $cont = 0;
    while ($row = $result->fetch_assoc()) {
        $cont++;
        if ($cont == 1) {
            $nameLastColumn = $row["c"];
        } else {
            $nameLastSecondColumn = $row["c"];
        }
    }
    $ultimoAggNazionale = str_replace("T", " alle ", $db->query("SELECT data FROM andamentoNazionale ORDER BY data desc LIMIT 1")->fetch_assoc()["data"]);
    ?>
    <ul class="list-group">
        <h4>Ultimo Aggiornamento</h4>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            DB Mondiale<span class="badge badge-primary badge-pill"><?= $nameLastColumn ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            DB Nazionale<span class="badge badge-primary badge-pill"><?= $ultimoAggNazionale ?></span>
        </li>
    </ul>
    <?php
    $totCasi = $db->query("SELECT SUM($nameLastColumn) as num FROM time_series_covid19_confirmed_global")->fetch_assoc()["num"];
    $totGuariti = $db->query("SELECT SUM($nameLastColumn) as num FROM time_series_covid19_recovered_global")->fetch_assoc()["num"];
    $totMorti = $db->query("SELECT SUM($nameLastColumn) as num FROM time_series_covid19_deaths_global")->fetch_assoc()["num"];
    $totPositivi = $totCasi - $totGuariti - $totMorti;

    $casiUltimoGiorno = $totCasi - $db->query("SELECT SUM($nameLastSecondColumn) as num FROM time_series_covid19_confirmed_global")->fetch_assoc()["num"];
    $percIncrementoCasi = $casiUltimoGiorno / $totCasi * 100;

    $guaritiUltimoGiorno = $totGuariti - $db->query("SELECT SUM($nameLastSecondColumn) as num FROM time_series_covid19_recovered_global")->fetch_assoc()["num"];
    $percIncrementoGuariti = $guaritiUltimoGiorno / $totCasi * 100;

    $mortiUltimoGiorno = $totMorti - $db->query("SELECT SUM($nameLastSecondColumn) as num FROM time_series_covid19_deaths_global")->fetch_assoc()["num"];
    $percIncrementoMorti = $mortiUltimoGiorno / $totCasi * 100;

    $positiviUltimoGiorno = ($casiUltimoGiorno - $guaritiUltimoGiorno - $mortiUltimoGiorno);
    $percIncrementoPositivi = $positiviUltimoGiorno / $totCasi * 100;

    $positiviSuCasi = $totPositivi / $totCasi * 100;
    $guaritiSuCasi = $totGuariti / $totCasi * 100;
    $mortiSuCasi = $totMorti / $totCasi * 100;
    ?>
    <p id="mondiali"></p><br><br>
    <ul class="list-group">
        <h4>Statistiche Mondiali</h4>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Incremento casi ultimo giorno
            <span class="badge badge-primary badge-pill"><?= "+" . number_format($casiUltimoGiorno, 0, '', ' ') . " (+ " . number_format($percIncrementoCasi, 2, ',', ' ') . "%)" ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Incremento positivi ultimo giorno
            <span class="badge badge-primary badge-pill"><?= "+" . number_format($positiviUltimoGiorno, 0, '', ' ') . " (+ " . number_format($percIncrementoPositivi, 2, ',', ' ') . "%)" ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Icremento guariti ultimo giorno
            <span class="badge badge-primary badge-pill"><?= "+" . number_format($guaritiUltimoGiorno, 0, '', ' ') . " (+ " . number_format($percIncrementoGuariti, 2, ',', ' ') . "%)" ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Incremento morti ultimo giorno
            <span class="badge badge-primary badge-pill"><?= "+" . number_format($mortiUltimoGiorno, 0, '', ' ') . " (+ " . number_format($percIncrementoMorti, 2, ',', ' ') . "%)" ?></span>
        </li>
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
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <h5>Top <?= $numOfTop ?> per totale dei casi</h5>
            <ol>
                <?php
                $sql = "SELECT country_region as c,province_state as p,$nameLastColumn as num FROM `time_series_covid19_confirmed_global` ORDER by cast($nameLastColumn as int) DESC limit " . $numOfTop;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . (!empty($row["p"]) ? $row['c'] . "(" . $row["p"] . ")" : $row['c']) . "<span class='badge badge-primary badge-pill ml-5'>" . $row['num'] . " ( " . number_format($row["num"] / $totCasi * 100, 2, ',', ' ') . "%)</span></li>";
                }
                ?>
            </ol>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <h5>Top <?= $numOfTop ?> per totale dei positivi</h5>
            <ol>
                <?php
                $sql = "SELECT t1.country_region as c,t1.province_state as p,cast(t1.$nameLastColumn as int)- cast((SELECT $nameLastColumn from `time_series_covid19_recovered_global` as t2 where t2.country_region= t1.country_region AND t2.province_state= t1.province_state ) as int)- cast((SELECT $nameLastColumn from `time_series_covid19_deaths_global` as t3 where t3.country_region= t1.country_region AND t3.province_state= t1.province_state ) as int) as num FROM `time_series_covid19_confirmed_global` as t1 ORDER by cast(num as int) DESC limit " . $numOfTop;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . (!empty($row["p"]) ? $row['c'] . "(" . $row["p"] . ")" : $row['c']) . "<span class='badge badge-primary badge-pill ml-5'>" . $row['num'] . " ( " . number_format($row["num"] / $totPositivi * 100, 2, ',', ' ') . "%)</span></li>";
                }
                ?>
            </ol>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <h5>Top <?= $numOfTop ?> per totale dei guariti</h5>
            <ol>
                <?php
                $sql = "SELECT country_region as c,province_state as p,$nameLastColumn as num FROM `time_series_covid19_recovered_global` ORDER by cast($nameLastColumn as int) DESC limit " . $numOfTop;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . (!empty($row["p"]) ? $row['c'] . "(" . $row["p"] . ")" : $row['c']) . "<span class='badge badge-primary badge-pill ml-5'>" . $row['num'] . " ( " . number_format($row["num"] / $totGuariti * 100, 2, ',', ' ') . "%)</span></li>";
                }
                ?>
            </ol>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <h5>Top <?= $numOfTop ?> per totale dei morti</h5>
            <ol>
                <?php
                $sql = "SELECT country_region as c,province_state as p,$nameLastColumn as num FROM `time_series_covid19_deaths_global` ORDER by cast($nameLastColumn as int) DESC limit " . $numOfTop;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . (!empty($row["p"]) ? $row['c'] . "(" . $row["p"] . ")" : $row['c']) . "<span class='badge badge-primary badge-pill ml-5'>" . $row['num'] . " ( " . number_format($row["num"] / $totMorti * 100, 2, ',', ' ') . "%)</span></li>";
                }
                ?>
            </ol>
        </li>
    </ul>
    <?php
    $totCasi = $db->query("SELECT totale_casi as num FROM andamentoNazionale ORDER BY data desc LIMIT 1")->fetch_assoc()["num"];
    $totGuariti = $db->query("SELECT dimessi_guariti as num FROM andamentoNazionale ORDER BY data desc LIMIT 1")->fetch_assoc()["num"];
    $totMorti = $db->query("SELECT deceduti as num FROM andamentoNazionale ORDER BY data desc LIMIT 1")->fetch_assoc()["num"];
    $totPositivi = $totCasi - $totGuariti - $totMorti;

    $casiUltimoGiorno = $totCasi - $db->query("SELECT totale_casi as num FROM andamentoNazionale WHERE id < (select max(id) from andamentoNazionale) ORDER BY data desc  LIMIT 1")->fetch_assoc()["num"];
    $percIncrementoCasi = $casiUltimoGiorno / $totCasi * 100;

    $positiviUltimoGiorno = $totPositivi - $db->query("SELECT totale_positivi as num FROM andamentoNazionale WHERE id < (select max(id) from andamentoNazionale) ORDER BY data desc  LIMIT 1")->fetch_assoc()["num"];
    $percIncrementoPositivi = $positiviUltimoGiorno / $totCasi * 100;

    $guaritiUltimoGiorno = $totGuariti - $db->query("SELECT dimessi_guariti as num FROM andamentoNazionale WHERE id < (select max(id) from andamentoNazionale) ORDER BY data desc  LIMIT 1")->fetch_assoc()["num"];
    $percIncrementoGuariti = $guaritiUltimoGiorno / $totCasi * 100;

    $mortiUltimoGiorno = $totMorti - $db->query("SELECT deceduti as num FROM andamentoNazionale WHERE id < (select max(id) from andamentoNazionale) ORDER BY data desc  LIMIT 1")->fetch_assoc()["num"];
    $percIncrementoMorti = $mortiUltimoGiorno / $totCasi * 100;

    $positiviSuCasi = $totPositivi / $totCasi * 100;
    $guaritiSuCasi = $totGuariti / $totCasi * 100;
    $mortiSuCasi = $totMorti / $totCasi * 100;
    ?>
    <p id="nazionali"></p><br><br>
    <ul class="list-group">
        <h4>Statistiche Nazionali</h4>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Incremento casi ultimo giorno
            <span class="badge badge-primary badge-pill"><?= "+" . number_format($casiUltimoGiorno, 0, '', ' ') . " (+ " . number_format($percIncrementoCasi, 2, ',', ' ') . "%)" ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Incremento positivi ultimo giorno
            <span class="badge badge-primary badge-pill"><?= "+" . number_format($positiviUltimoGiorno, 0, '', ' ') . " (+ " . number_format($percIncrementoPositivi, 2, ',', ' ') . "%)" ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Icremento guariti ultimo giorno
            <span class="badge badge-primary badge-pill"><?= "+" . number_format($guaritiUltimoGiorno, 0, '', ' ') . " (+ " . number_format($percIncrementoGuariti, 2, ',', ' ') . "%)" ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Incremento morti ultimo giorno
            <span class="badge badge-primary badge-pill"><?= "+" . number_format($mortiUltimoGiorno, 0, '', ' ') . " (+ " . number_format($percIncrementoMorti, 2, ',', ' ') . "%)" ?></span>
        </li>
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
    <p id="regionali"></p><br><br>
    <ul class="list-group">
        <h4>Statistiche Regionali</h4>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <h5>Top <?= $numOfTop ?> per totale dei casi</h5>
            <ol>
                <?php
                $sql = "SELECT a1.denominazione_regione as r, a1.totale_casi as t FROM (SELECT * FROM andamentoRegionale ORDER BY data desc LIMIT 21) as a1 ORDER BY CAST(t AS INT) desc LIMIT " . $numOfTop;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $row['r'] . "<span class='badge badge-primary badge-pill ml-5'>" . $row['t'] . "</span></li>";
                }
                ?>
            </ol>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <h5>Top <?= $numOfTop ?> per totale dei positivi</h5>
            <ol>
                <?php
                $sql = "SELECT a1.denominazione_regione as r, a1.totale_positivi as t FROM (SELECT * FROM andamentoRegionale ORDER BY data desc LIMIT 21) as a1 ORDER BY CAST(t AS INT) desc LIMIT " . $numOfTop;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $row['r'] . "<span class='badge badge-primary badge-pill ml-5'>" . $row['t'] . "</span></li>";
                }
                ?>
            </ol>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <h5>Top <?= $numOfTop ?> per totale dei guariti</h5>
            <ol>
                <?php
                $sql = "SELECT a1.denominazione_regione as r, a1.dimessi_guariti as t FROM (SELECT * FROM andamentoRegionale ORDER BY data desc LIMIT 21) as a1 ORDER BY CAST(t AS INT) desc LIMIT " . $numOfTop;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $row['r'] . "<span class='badge badge-primary badge-pill ml-5'>" . $row['t'] . "</span></li>";
                }
                ?>
            </ol>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <h5>Top <?= $numOfTop ?> per totale dei deceduti</h5>
            <ol>
                <?php
                $sql = "SELECT a1.denominazione_regione as r, a1.deceduti as t FROM (SELECT * FROM andamentoRegionale ORDER BY data desc LIMIT 21) as a1 ORDER BY CAST(t AS INT) desc LIMIT " . $numOfTop;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $row['r'] . "<span class='badge badge-primary badge-pill ml-5'>" . $row['t'] . "</span></li>";
                }
                ?>
            </ol>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <h5>Top <?= $numOfTop ?> per totale positivi su casi</h5>
            <ol>
                <?php
                $sql = "SELECT a1.denominazione_regione as r, a1.totale_casi as c, a1.totale_positivi as d FROM (SELECT * FROM andamentoRegionale ORDER BY data desc LIMIT 21) as a1 ORDER BY CAST(d AS INT)/CAST(c AS INT) desc LIMIT " . $numOfTop;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $row['r'] . "<span class='badge badge-primary badge-pill ml-5'>" . (round($row['d'] / $row['c'] * 100, 2)) . " %</span></li>";
                }
                ?>
            </ol>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <h5>Top <?= $numOfTop ?> per totale guariti su casi</h5>
            <ol>
                <?php
                $sql = "SELECT a1.denominazione_regione as r, a1.totale_casi as c, a1.dimessi_guariti as d FROM (SELECT * FROM andamentoRegionale ORDER BY data desc LIMIT 21) as a1 ORDER BY CAST(d AS INT)/CAST(c AS INT) desc LIMIT " . $numOfTop;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $row['r'] . "<span class='badge badge-primary badge-pill ml-5'>" . (round($row['d'] / $row['c'] * 100, 2)) . " %</span></li>";
                }
                ?>
            </ol>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <h5>Top <?= $numOfTop ?> per totale morti su casi</h5>
            <ol>
                <?php
                $sql = "SELECT a1.denominazione_regione as r, a1.totale_casi as c, a1.deceduti as d FROM (SELECT * FROM andamentoRegionale ORDER BY data desc LIMIT 21) as a1 ORDER BY CAST(d AS INT)/CAST(c AS INT) desc LIMIT " . $numOfTop;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $row['r'] . "<span class='badge badge-primary badge-pill ml-5'>" . (round($row['d'] / $row['c'] * 100, 2)) . " %</span></li>";
                }
                ?>
            </ol>
        </li>
    </ul>
    <p id="provinciali"></p><br><br>
    <ul class="list-group">
        <h4>Statistiche Provinciali</h4>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <h5>Top <?= $numOfTop ?> per totale dei casi</h5>
            <ol>
                <?php
                $sql = "SELECT a1.denominazione_provincia as p,a1.denominazione_regione as r, a1.totale_casi as t FROM (SELECT * FROM andamentoProvinciale ORDER BY data desc LIMIT 128) as a1 ORDER BY CAST(t AS INT) desc LIMIT " . $numOfTop;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $row['p'] . " (" . $row['r'] . ")<span class='badge badge-primary badge-pill ml-5'>" . $row['t'] . "</span></li>";
                }
                ?>
            </ol>
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
    <script>
        $("button.btn").click(function() {
            if (window.location.href.includes("?")) {
                window.location = window.location.href.split("?")[0] + "?limitTop=" + $("input#input1").val();
            } else {
                window.location = window.location.href + "?limitTop=" + $("input#input1").val();
            }
        });
        $("input#input1").keyup(function(e) {
            //console.log(e.keyCode)
            if (e.keyCode == 13) {
                $("button.btn").trigger("click");
            }
        });
    </script>
</body>

</html>