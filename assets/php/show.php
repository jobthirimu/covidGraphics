<?php
$id = $_REQUEST["id"];
$url = "";

if ($id == 1) {
    $url = "https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_time_series/time_series_19-covid-Confirmed.csv";
} else if ($id == 2) {
    $url = "https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_time_series/time_series_19-covid-Recovered.csv";
} else if ($id == 3) {
    $url = "https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_time_series/time_series_19-covid-Deaths.csv";
}
//mostro la api
?>
<input type="hidden" id="hidden" title="<?php echo $url ?>">
<script src="assets/js/show.js"></script>