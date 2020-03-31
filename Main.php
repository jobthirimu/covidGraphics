<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covid-Graphics</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar bg-dark navbar-dark">
        <a class="navbar-brand" href="#" id="home">Home</a>
        <div class="form-inline">
            <div class="btn-group">
                <a id="1" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" changed="false">Origine Dati<span class='caret'></span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item">Mondiale</li>
                    <li class="dropdown-item"><a href="#">Nazionale</a></li>
                    <li class="dropdown-item"><a href="#">Regionale</a></li>
                    <li class="dropdown-item"><a href="#">Provinciale</a></li>
                    <li class="dropdown-item">Comunale</li>
                </ul>
            </div>
            <input id="input1" type="text" class="form-control" placeholder="Search">
        </div>
        <div class="btn-group">
            <a id="2" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" changed="false">Quale Grafico<span class='caret'></span></a>
            <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="#">Totale Casi</a></li>
                <li class="dropdown-item"><a href="#">Totale Positivi</a></li>
                <li class="dropdown-item"><a href="#">Variazione Totale Positivi</a></li>
                <li class="dropdown-item"><a href="#">Nuovi Positivi</a></li>
                <li class="dropdown-item"><a href="#">Totale Guariti</a></li>
                <li class="dropdown-item"><a href="#">Totale Morti</a></li>
                <li class="dropdown-item"><a href="#">Nuovi Morti</a></li>
            </ul>
        </div>
        <div class="btn-group">
            <a id="3" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" changed="false">Tipo Grafico<span class='caret'></span></a>
            <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="#">Grafico a linee vuoto</a></li>
                <li class="dropdown-item"><a href="#">Grafico a linee pieno</a></li>
                <li class="dropdown-item"><a href="#">Grafico a barre</a></li>
                <li class="dropdown-item"><a href="#">Grafico a radar</a></li>
                <li class="dropdown-item"><a href="#">Grafico a doughnut</a></li>
                <li class="dropdown-item"><a href="#">Grafico a torta</a></li>
                <li class="dropdown-item"><a href="#">Grafico ad area polare</a></li>
            </ul>
        </div>
        <form class="form-inline">
            <button class="btn btn-outline-primary" type="button">Disegna Grafico</button>
        </form>
    </nav>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-sm">
                <br>
                <h3 id="titolo" class="text-center">Benvenuto nella pagina dei grafici relativi al covid-2019</h3>
                <br><br>
                <h4 id="stats">
                    ● Casi totali in italia
                    <?php
                    include("assets/php/db_connect.php");
                    echo " : " . $db->query("SELECT totale_casi as num FROM andamentoNazionale ORDER BY data desc LIMIT 1")->fetch_assoc()["num"];
                    ?>
                    <br><br>
                    ● Regioni più colpite(casi totali) :
                    <ol>
                        <?php
                        $sql = "SELECT a1.denominazione_regione as r, a1.totale_casi as t FROM (SELECT * FROM andamentoRegionale ORDER BY data desc LIMIT 21) as a1 ORDER BY CAST(t AS INT) desc LIMIT 5";
                        $regionipiucolpite = $db->query($sql);
                        while ($row = $regionipiucolpite->fetch_assoc()) {
                            echo "<li>" . $row['r'] . " : " . $row['t'] . " casi</li>";
                        }
                        ?>
                    </ol>
                    ● Provincie più colpite(casi totali) :
                    <ol>
                        <?php
                        $sql = "SELECT a1.denominazione_provincia as p,a1.denominazione_regione as r, a1.totale_casi as t FROM (SELECT * FROM andamentoProvinciale ORDER BY data desc LIMIT 128) as a1 ORDER BY CAST(t AS INT) desc LIMIT 5";
                        $provinciepiucolpite = $db->query($sql);
                        while ($row = $provinciepiucolpite->fetch_assoc()) {
                            echo "<li>" . $row['p'] . "(" . $row["r"] . ")" . " : " . $row['t'] . " casi</li>";
                        }
                        ?>
                    </ol>
                    <br>
                    ● Primo Aggiornamento
                    <?php
                    echo " : " . str_replace("T", " alle ", $db->query("SELECT data FROM andamentoNazionale ORDER BY data asc LIMIT 1")->fetch_assoc()["data"]);
                    ?>
                    <br>
                    ● Ultimo Aggiornamento
                    <?php
                    echo " : " . str_replace("T", " alle ", $db->query("SELECT data FROM andamentoNazionale ORDER BY data desc LIMIT 1")->fetch_assoc()["data"]);
                    ?>
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <div id="chart-container">
                    <canvas id="graphCanvas"></canvas>
                </div>
            </div>
        </div>
    </div>
    <footer class="page-footer font-small blue pt-4">
        <div class="footer-copyright text-center py-3">
            Created by Marco Zanrosso©
            <!-- <a href="https://mdbootstrap.com/"> MDBootstrap.com</a> -->
        </div>

    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        var graph;
        $(".dropdown-menu li a").click(function() {
            var selText = $(this).text();
            $(this).parents('.btn-group').find('.dropdown-toggle').html(selText + '<span class="caret"></span>');
            $(this).parents('.btn-group').find('.dropdown-toggle').attr("changed", selText);
        });
        $("a#home").click(function() {
            location.reload();
        });
        $("input#input1").keyup(function(e) {
            if (e.keyCode == 13) {
                $("button").trigger("click");
            }
        });
        $("button").click(function() {
            var choose1 = $("#1").attr("changed") != "false" ? $("#1").attr("changed") : "false";
            var choose2 = $("#2").attr("changed") != "false" ? $("#2").attr("changed") : "false";
            var choose3 = $("#3").attr("changed") != "false" ? $("#3").attr("changed") : "false";
            var input = $("#input1").val() != "" ? $("#input1").val() : "err";
            //alert(input);
            //alert("ch1: " + choose1 + " ch2: " + choose2 + " ch3: " + choose3); //check clicked property
            if ((choose1 != "false" && choose2 != "false" && choose3 != "false")) {
                //alert("input:" + input);
                if (graph != undefined) {
                    graph.destroy();
                    //alert("grafico distrutto");
                }
                $("h4#stats").html("");
                $.ajax({
                    // definisco il tipo della chiamata
                    type: "POST",
                    // specifico la URL della risorsa da contattare
                    url: "assets/php/graph.php",
                    // passo dei dati alla risorsa remota
                    data: {
                        "choose1": choose1,
                        "choose2": choose2,
                        "input": input,
                    },
                    // definisco il formato della risposta
                    dataType: "text",
                    // imposto un'azione per il caso di successo
                    success: function(data) {
                        var agg = 0;
                        var regioni = [
                            "abruzzo",
                            "basilicata",
                            "p.a. bolzano",
                            "calabria",
                            "campania",
                            "emilia romagna",
                            "friuli venezia giulia",
                            "lazio",
                            "liguria",
                            "lombardia",
                            "marche",
                            "molise",
                            "piemonte",
                            "puglia",
                            "sardegna",
                            "sicilia",
                            "toscana",
                            "p.a. trento",
                            "umbria",
                            "valle d'aosta",
                            "veneto"
                        ];
                        var provincesuregioni = {
                            "abruzzo": 5,
                            "basilicata": 3,
                            "p.a. bolzano": 2,
                            "calabria": 6,
                            "campania": 6,
                            "emilia romagna": 10,
                            "friuli venezia giulia": 5,
                            "lazio": 6,
                            "liguria": 5,
                            "lombardia": 13,
                            "marche": 6,
                            "molise": 3,
                            "piemonte": 9,
                            "puglia": 7,
                            "sardegna": 6,
                            "sicilia": 10,
                            "toscana": 11,
                            "p.a. trento": 2,
                            "umbria": 3,
                            "valle d'aosta": 2,
                            "veneto": 8
                        };
                        if (((choose1 == "Regionale" || choose1 == "Provinciale") && input == "err") || (choose1 == "Provinciale" && jQuery.inArray(input.toLowerCase(), regioni) != -1)) {
                            var pieces = data;
                            pieces = pieces.split('£');
                            data = JSON.parse(pieces[0]);
                            agg = parseInt(pieces[1], 10);
                        } else {
                            data = JSON.parse(data);
                        }
                        console.log("p1:" + data);
                        console.log("p2:" + agg);
                        var strX = "data";
                        var strY = "";
                        var typeG = "line";
                        var filled = true;
                        switch (choose2) {
                            case "Totale Casi":
                                strY = "totale_casi";
                                break;
                            case "Totale Positivi":
                                strY = "totale_positivi";
                                break;
                            case "Variazione Totale Positivi":
                                strY = "variazione_totale_positivi";
                                break;
                            case "Nuovi Positivi":
                                strY = "nuovi_positivi";
                                break;
                            case "Totale Guariti":
                                strY = "dimessi_guariti";
                                break;
                            case "Totale Morti":
                                strY = "deceduti";
                                break;
                            case "Nuovi Morti":
                                strY = "nuovi_deceduti";
                                break;
                        }
                        switch (choose3) {
                            case "Grafico a linee vuoto":
                                typeG = "line";
                                filled = false;
                                break;
                            case "Grafico a linee pieno":
                                typeG = "line";
                                break;
                            case "Grafico a barre":
                                typeG = "bar";
                                break;
                            case "Grafico a radar":
                                typeG = "radar";
                                break;
                            case "Grafico a doughnut":
                                typeG = "doughnut";
                                break;
                            case "Grafico a torta":
                                typeG = "pie";
                                break;
                            case "Grafico ad area polare":
                                typeG = "polarArea";
                                break;
                        }
                        if (choose2 != "Nuovi Infetti") {
                            $("h3#titolo").html("<h2 id='bm2'>" + choose3 + " " + choose1 + " con il " + choose2 + "</h2><br><br>");
                        } else {
                            $("h3#titolo").html("<h2 id='bm2'>" + choose3 + " " + choose1 + " con i " + choose2 + "</h2><br><br>");
                        }
                        var dict = [];
                        if (((choose1 == "Regionale" || choose1 == "Provinciale") && input == "err") || (choose1 == "Provinciale" && jQuery.inArray(input.toLowerCase(), regioni) != -1)) {
                            //agg = agg == 0 ? provincesuregioni[input.toLowerCase()] : agg;
                            //console.log("ris:" + jQuery.inArray(input, regioni));
                            var asseY = [];
                            var asseX = [];
                            var bColor = [];
                            var date = [];
                            var cont = 0;
                            for (var i in data) {
                                cont++;
                                r = Math.floor(Math.random() * 200);
                                g = Math.floor(Math.random() * 200);
                                b = Math.floor(Math.random() * 200);
                                col = 'rgb(' + r + ', ' + g + ', ' + b + ')';
                                var lbl = choose1 == "Regionale" ? data[i]["denominazione_regione"] : data[i]["denominazione_provincia"];
                                asseY.push(data[i][strY]);
                                asseX.push(data[i]["data"]);
                                if (cont % agg == 0) {
                                    dict.push({
                                        label: lbl,
                                        fill: filled,
                                        //backgroundColor: col,
                                        borderColor: col,
                                        hoverBackgroundColor: '#CCCCCC',
                                        hoverBorderColor: '#666666',
                                        data: asseY,
                                    });
                                    asseY = [];
                                    if (cont == agg) {
                                        date = [...asseX];
                                    }
                                }
                            }
                            chartdata = { //da testare/eliminare
                                data: {
                                    dataset: dict,
                                    labels: date
                                },
                            };
                        } else {
                            var asseY = [];
                            var date = [];
                            var bColor = [];
                            for (var i in data) {
                                r = Math.floor(Math.random() * 200);
                                g = Math.floor(Math.random() * 200);
                                b = Math.floor(Math.random() * 200);
                                c = 'rgb(' + r + ', ' + g + ', ' + b + ')';
                                date.push(data[i][strX]);
                                asseY.push(data[i][strY]);
                                bColor.push(c);
                            }
                            //console.log(asseY); 
                            dict = [{
                                label: choose2,
                                fill: filled,
                                //backgroundColor: '#49e2ff',
                                backgroundColor: typeG != "line" && typeG != "radar" && typeG != "bar" ? bColor : '#49e2ff',
                                //backgroundColor: bColor,
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: asseY
                            }];
                        }

                        var graphTarget = $("#graphCanvas");

                        console.log(dict);
                        console.log(date);
                        graph = new Chart(
                            graphTarget, {
                                responsive: true,
                                type: typeG,
                                data: {
                                    datasets: dict,
                                    labels: date,
                                }
                            });
                        console.log(graph);
                    },
                    // ed una per il caso di fallimento
                    error: function(err) {
                        console.log(err);
                    }
                });
            } else {
                alert("Inserisci tutte le informazioni per procedere \r\n alla creazione del grafico");
            }
        });
    </script>
</body>
</html>