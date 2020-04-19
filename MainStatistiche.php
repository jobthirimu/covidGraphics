<?php
include("assets/php/db_connect.php");
$numOfTop = !empty($_REQUEST["limitTop"]) ? $_REQUEST["limitTop"] : 5;
$eu_countries = array(
    "Albania",
    "Andorra",
    "Armenia",
    "Austria",
    "Azerbaijan",
    "Belarus",
    "Belgium",
    "Bosnia and Herzegovina",
    "Bulgaria",
    "Croatia",
    "Cyprus",
    "Czech Republic",
    "Denmark",
    "Estonia",
    "Finland",
    "France",
    "Georgia",
    "Germany",
    "Greece",
    "Hungary",
    "Iceland",
    "Ireland",
    "Italy",
    "Kosovo",
    "Latvia",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Macedonia",
    "Malta",
    "Moldova",
    "Monaco",
    "Montenegro",
    "The Netherlands",
    "Norway",
    "Poland",
    "Portugal",
    "Romania",
    "Russia",
    "San Marino",
    "Serbia",
    "Slovakia",
    "Slovenia",
    "Spain",
    "Sweden",
    "Switzerland",
    "Turkey",
    "Ukraine",
    "United Kingdom",
    "Vatican City",
);
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
$ultimoAggNazionale = str_replace("T", " at ", $db->query("SELECT data FROM andamentoNazionale ORDER BY data desc LIMIT 1")->fetch_assoc()["data"]);
?>
<ul class="list-group">
    <h4>Last Update</h4>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        World jhu csse database<span class="badge badge-primary badge-pill"><?= $nameLastColumn ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Italy civil protection database<span class="badge badge-primary badge-pill"><?= $ultimoAggNazionale ?></span>
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

$euCountryConditions = "";
foreach ($eu_countries as $val) {
    $euCountryConditions .= " OR country_region like '$val' ";
}
?>
<p id="mondiali"></p><br><br>
<ul class="list-group">
    <h4>World Statistics</h4>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Increase in cases last day
        <span class="badge badge-primary badge-pill"><?= number_format($casiUltimoGiorno, 0, '', ' ') . " ( " . number_format($percIncrementoCasi, 2, ',', ' ') . "%)" ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Positive increases last day
        <span class="badge badge-primary badge-pill"><?= number_format($positiviUltimoGiorno, 0, '', ' ') . " ( " . number_format($percIncrementoPositivi, 2, ',', ' ') . "%)" ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Increase healed last day
        <span class="badge badge-primary badge-pill"><?= number_format($guaritiUltimoGiorno, 0, '', ' ') . " ( " . number_format($percIncrementoGuariti, 2, ',', ' ') . "%)" ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Increase in deaths on the last day
        <span class="badge badge-primary badge-pill"><?= number_format($mortiUltimoGiorno, 0, '', ' ') . " ( " . number_format($percIncrementoMorti, 2, ',', ' ') . "%)" ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Total of cases
        <span class="badge badge-primary badge-pill"><?= number_format($totCasi, 0, '', ' ') ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Total positive
        <span class="badge badge-primary badge-pill"><?= number_format($totPositivi, 0, '', ' ') ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Total of healed
        <span class="badge badge-primary badge-pill"><?= number_format($totGuariti, 0, '', ' ') ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Total of dead
        <span class="badge badge-primary badge-pill"><?= number_format($totMorti, 0, '', ' ') ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Positive percentage of total cases
        <span class="badge badge-primary badge-pill"><?= number_format($positiviSuCasi, 2, ',', ' ') . "%" ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Percentage cured of total cases
        <span class="badge badge-primary badge-pill"><?= number_format($guaritiSuCasi, 2, ',', ' ') . "%"  ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Percentage of deaths out of total cases
        <span class="badge badge-primary badge-pill"><?= number_format($mortiSuCasi, 2, ',', ' ') . "%"  ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h5>Top <?= $numOfTop ?> for total cases</h5>
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
        <h5>Top <?= $numOfTop ?> for total cases in Europe</h5>
        <ol>
            <?php
            $sql = "SELECT country_region as c,province_state as p,$nameLastColumn as num FROM `time_series_covid19_confirmed_global` WHERE country_region like '' $euCountryConditions ORDER by cast($nameLastColumn as int) DESC limit " . $numOfTop;
            $result = $db->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . (!empty($row["p"]) ? $row['c'] . "(" . $row["p"] . ")" : $row['c']) . "<span class='badge badge-primary badge-pill ml-5'>" . $row['num'] . " ( " . number_format($row["num"] / $totCasi * 100, 2, ',', ' ') . "%)</span></li>";
            }
            ?>
        </ol>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h5>Top <?= $numOfTop ?> for total positives</h5>
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
        <h5>Top <?= $numOfTop ?> for total positives in Europe</h5>
        <ol>
            <?php
            $sql = "SELECT t1.country_region as c,t1.province_state as p,cast(t1.$nameLastColumn as int)- cast((SELECT $nameLastColumn from `time_series_covid19_recovered_global` as t2 where t2.country_region= t1.country_region AND t2.province_state= t1.province_state ) as int)- cast((SELECT $nameLastColumn from `time_series_covid19_deaths_global` as t3 where t3.country_region= t1.country_region AND t3.province_state= t1.province_state ) as int) as num FROM `time_series_covid19_confirmed_global` as t1 WHERE country_region like '' $euCountryConditions ORDER by cast(num as int) DESC limit " . $numOfTop;
            $result = $db->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . (!empty($row["p"]) ? $row['c'] . "(" . $row["p"] . ")" : $row['c']) . "<span class='badge badge-primary badge-pill ml-5'>" . $row['num'] . " ( " . number_format($row["num"] / $totPositivi * 100, 2, ',', ' ') . "%)</span></li>";
            }
            ?>
        </ol>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h5>Top <?= $numOfTop ?> for total healed</h5>
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
        <h5>Top <?= $numOfTop ?> for total healed in europe</h5>
        <ol>
            <?php
            $sql = "SELECT country_region as c,province_state as p,$nameLastColumn as num FROM `time_series_covid19_recovered_global` WHERE country_region like '' $euCountryConditions ORDER by cast($nameLastColumn as int) DESC limit " . $numOfTop;
            $result = $db->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . (!empty($row["p"]) ? $row['c'] . "(" . $row["p"] . ")" : $row['c']) . "<span class='badge badge-primary badge-pill ml-5'>" . $row['num'] . " ( " . number_format($row["num"] / $totGuariti * 100, 2, ',', ' ') . "%)</span></li>";
            }
            ?>
        </ol>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h5>Top <?= $numOfTop ?> for total deaths</h5>
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
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h5>Top <?= $numOfTop ?> for total deaths in europe</h5>
        <ol>
            <?php
            $sql = "SELECT country_region as c,province_state as p,$nameLastColumn as num FROM `time_series_covid19_deaths_global` WHERE country_region like '' $euCountryConditions ORDER by cast($nameLastColumn as int) DESC limit " . $numOfTop;
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
$totTamponi = $db->query("SELECT tamponi as num FROM andamentoNazionale ORDER BY data desc LIMIT 1")->fetch_assoc()["num"];
$totPositivi = $totCasi - $totGuariti - $totMorti;

$casiUltimoGiorno = $totCasi - $db->query("SELECT totale_casi as num FROM andamentoNazionale WHERE id < (select max(id) from andamentoNazionale) ORDER BY data desc  LIMIT 1")->fetch_assoc()["num"];
$percIncrementoCasi = $casiUltimoGiorno / $totCasi * 100;

$positiviUltimoGiorno = $totPositivi - $db->query("SELECT totale_positivi as num FROM andamentoNazionale WHERE id < (select max(id) from andamentoNazionale) ORDER BY data desc  LIMIT 1")->fetch_assoc()["num"];
$percIncrementoPositivi = $positiviUltimoGiorno / $totCasi * 100;

$guaritiUltimoGiorno = $totGuariti - $db->query("SELECT dimessi_guariti as num FROM andamentoNazionale WHERE id < (select max(id) from andamentoNazionale) ORDER BY data desc  LIMIT 1")->fetch_assoc()["num"];
$percIncrementoGuariti = $guaritiUltimoGiorno / $totCasi * 100;

$mortiUltimoGiorno = $totMorti - $db->query("SELECT deceduti as num FROM andamentoNazionale WHERE id < (select max(id) from andamentoNazionale) ORDER BY data desc  LIMIT 1")->fetch_assoc()["num"];
$percIncrementoMorti = $mortiUltimoGiorno / $totCasi * 100;

$tamponiUltimoGiorno = $totTamponi - $db->query("SELECT tamponi as num FROM andamentoNazionale WHERE id < (select max(id) from andamentoNazionale) ORDER BY data desc  LIMIT 1")->fetch_assoc()["num"];
$percIncrementoTamponi = $tamponiUltimoGiorno / $totTamponi * 100;
$percTotcasiSuTamponi = $totCasi / $totTamponi * 100;
$percCasiSuTamponi = $casiUltimoGiorno / $tamponiUltimoGiorno * 100;

$positiviSuCasi = $totPositivi / $totCasi * 100;
$guaritiSuCasi = $totGuariti / $totCasi * 100;
$mortiSuCasi = $totMorti / $totCasi * 100;
?>
<p id="nazionali"></p><br><br>
<ul class="list-group">
    <h4>Italy Statistics</h4>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Increase in swabs last day
        <span class="badge badge-primary badge-pill"><?= number_format($tamponiUltimoGiorno, 0, '', ' ') . " ( " . number_format($percIncrementoTamponi, 2, ',', ' ') . "%)" ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Increase in cases last day
        <span class="badge badge-primary badge-pill"><?= number_format($casiUltimoGiorno, 0, '', ' ') . " ( " . number_format($percIncrementoCasi, 2, ',', ' ') . "%)" ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Positive increases last day
        <span class="badge badge-primary badge-pill"><?= number_format($positiviUltimoGiorno, 0, '', ' ') . " ( " . number_format($percIncrementoPositivi, 2, ',', ' ') . "%)" ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Increase healed last day
        <span class="badge badge-primary badge-pill"><?= number_format($guaritiUltimoGiorno, 0, '', ' ') . " ( " . number_format($percIncrementoGuariti, 2, ',', ' ') . "%)" ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Increase in deaths on the last day
        <span class="badge badge-primary badge-pill"><?= number_format($mortiUltimoGiorno, 0, '', ' ') . " ( " . number_format($percIncrementoMorti, 2, ',', ' ') . "%)" ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Total of swabs
        <span class="badge badge-primary badge-pill"><?= number_format($totTamponi, 0, '', ' ') ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Total of cases
        <span class="badge badge-primary badge-pill"><?= number_format($totCasi, 0, '', ' ') ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Total positive
        <span class="badge badge-primary badge-pill"><?= number_format($totPositivi, 0, '', ' ') ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Total of healed
        <span class="badge badge-primary badge-pill"><?= number_format($totGuariti, 0, '', ' ') ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Total of dead
        <span class="badge badge-primary badge-pill"><?= number_format($totMorti, 0, '', ' ') ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Percentage of last day cases on last day swabs
        <span class="badge badge-primary badge-pill"><?= number_format($percCasiSuTamponi, 2, ',', ' ') . "%"  ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Percentage of total cases on total swabs
        <span class="badge badge-primary badge-pill"><?= number_format($percTotcasiSuTamponi, 2, ',', ' ') . "%"  ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Positive percentage of total cases
        <span class="badge badge-primary badge-pill"><?= number_format($positiviSuCasi, 2, ',', ' ') . "%" ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Percentage cured of total cases
        <span class="badge badge-primary badge-pill"><?= number_format($guaritiSuCasi, 2, ',', ' ') . "%"  ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Percentage of deaths out of total cases
        <span class="badge badge-primary badge-pill"><?= number_format($mortiSuCasi, 2, ',', ' ') . "%"  ?></span>
    </li>
</ul>
<p id="regionali"></p><br><br>
<ul class="list-group">
    <h4>Statistics on the Italian regions</h4>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h5>Top <?= $numOfTop ?> for total cases</h5>
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
        <h5>Top <?= $numOfTop ?> for total positives</h5>
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
        <h5>Top <?= $numOfTop ?> for total healed</h5>
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
        <h5>Top <?= $numOfTop ?> for total deceased</h5>
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
        <h5>Top <?= $numOfTop ?> for total positives on cases</h5>
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
        <h5>Top <?= $numOfTop ?> for total healed cases</h5>
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
        <h5>Top <?= $numOfTop ?> for total deaths on cases</h5>
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
    <h4>Statistics on the Italian province</h4>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h5>Top <?= $numOfTop ?> for total cases</h5>
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
<br>
<h4 class="text-center">Thanks for reading all the statistics, at the top you can also generate graphs <br> if the site has helped you, do not hesitate to share it!</h4>