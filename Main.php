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
                    <li class="dropdown-item">Provinciale</li>
                    <li class="dropdown-item">Comunale</li>
                </ul>
            </div>
            <input id="input1" type="text" class="form-control" placeholder="Search">
        </div>
        <div class="btn-group">
            <a id="2" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" changed="false">Quale Grafico<span class='caret'></span></a>
            <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="#">Confronto</a></li>
                <li class="dropdown-item"><a href="#">Totale Casi</a></li>
                <li class="dropdown-item"><a href="#">Totale Attualmente Infetti</a></li>
                <li class="dropdown-item"><a href="#">Nuovi Infetti</a></li>
                <li class="dropdown-item"><a href="#">Totale Guariti</a></li>
                <li class="dropdown-item"><a href="#">Totale Morti</a></li>
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
            <button class="btn btn-outline-success" type="button">Disegna Grafico</button>
        </form>
    </nav>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-sm">
                <br>
                <h3 id="titolo" class="text-center">Benvenuto nella pagina dei grafici relativi al covid-2019</h3>
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
        var required = "false";
        var graph;
        $(".dropdown-menu li a").click(function() {
            var selText = $(this).text();
            $(this).parents('.btn-group').find('.dropdown-toggle').html(selText + '<span class="caret"></span>');
            $(this).parents('.btn-group').find('.dropdown-toggle').attr("changed", selText);
            switch (selText) {
                case "Mondiale": {
                    required = "false"
                };
                break;
            case "Nazionale": {
                required = "false"
            };
            break;
            case "Regionale": {
                required = "true"
            };
            break;
            case "Provinciale": {
                required = "true"
            };
            break;
            case "Comunale": {
                required = "true"
            };
            break;
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
                //alert("required:" + required + " input:" + input);
                if ((required == "true" && input != "err") || required == "false") {
                    if (graph != undefined) {
                        graph.destroy();
                        //alert("grafico distrutto");
                    }
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
                            var agg;
                            if (choose2 == "Confronto") {
                                var pieces = data;
                                pieces = pieces.split('£');
                                data = JSON.parse(pieces[0]);
                                agg = parseInt(pieces[1], 10);
                            } else {
                                data = JSON.parse(data);
                            }
                            //console.log("p1:" + data);
                            //console.log("p2:" + agg);
                            var strX = "data";
                            var strY = "";
                            var typeG = "line";
                            var filled = true;
                            switch (choose2) {
                                case "Totale Casi":
                                    strY = "totale_casi";
                                    break;
                                case "Totale Attualmente Infetti":
                                    strY = "totale_attualmente_positivi";
                                    break;
                                case "Nuovi Infetti":
                                    strY = "nuovi_attualmente_positivi";
                                    break;
                                case "Totale Guariti":
                                    strY = "dimessi_guariti";
                                    break;
                                case "Totale Morti":
                                    strY = "deceduti";
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
                            if (choose2 != "Confronto") {
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
                                console.log(asseY);
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
                            } else {
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
                                    var lbl = data[i]["denominazione_regione"];
                                    asseY.push(data[i]["totale_casi"]);
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
                                chartdata = {
                                    data: {
                                        dataset: dict,
                                        labels: date
                                    },
                                };
                            }

                            var graphTarget = $("#graphCanvas");

                            console.log(dict);
                            console.log(date);
                            graph = new Chart(
                                graphTarget, {
                                    responsive: true,
                                    type: typeG,
                                    data: {
                                        dataset: dict,
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
                    alert("Inserisci il luogo della ricerca");
                }
            } else {
                alert("Inserisci tutte le informazioni per procedere \r\n alla creazione del grafico");
            }
        });
        $("#home").click(function() {
            location.reload();
        });
    </script>
</body>

</html>