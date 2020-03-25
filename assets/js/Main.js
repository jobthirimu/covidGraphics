$("document").ready(function () {
    var graph;
    $("div#1").click(function () {
        if (graph != null) {
            graph.destroy();
        } //tolgo i grafici precedenti
        $("div.contenitore").html(""); //svuto contenitore
        $("nav#subnav").html("<div id='tutto'>Aggiorna tutti i dati</div><div id='naz'>Aggiorna dati nazionali</div><div id='reg'>Aggiorna dati regionali</div><div id='prov'>Aggiorna dati provinciali</div>");
        $("nav#subnav div").click(function () {
            var DivId = this.id;
            console.log(DivId);
            if (graph != null) {
                graph.destroy();
            } //tolgo i grafici precedenti
            $("div.contenitore").html(""); //svuto contenitore
            $("div.contenitore").append("<h2>Aggiornamento in corso<br>Attendi un istante</h2><br><br>");
            $.ajax({
                // definisco il tipo della chiamata
                type: "POST",
                // specifico la URL della risorsa da contattare
                url: "assets/php/update.php",
                // passo dei dati alla risorsa remota
                data: { "id": DivId },
                // definisco il formato della risposta
                dataType: "html",
                // imposto un'azione per il caso di successo
                success: function (risposta) {
                    $("div.contenitore").html("<h3>" + risposta + "</h3>");
                },
                // ed una per il caso di fallimento
                error: function (err) {
                    console.log(err);
                }
            })
            return false;
        });
    });
    $("nav#head div").click(function () {
        console.log(this.id);
        $("div.contenitore").empty(); //svuoto il contenitore da possibili scritte
        if (graph != null) {
            graph.destroy();
        } //tolgo i grafici precedenti
        var idDiv = this.id;
        if (this.id != 1) {
            $("nav#subnav").html("<div id='line'>Grafico a <br>linee</div><div id='bar'>Grafico a <br>barre</div><div id='radar'>Grafico a <br>radar</div><div id='doughnut'>Grafico a <br>doughnut</div><div id='pie'>Grafico a <br>torta</div><div id='polarArea'>Grafico ad <br>area polare</div>");
            $("nav#subnav div").click(function () {
                var idSubDiv = this.id;
                console.log(idSubDiv);
                showGraph(idDiv, $("div#" + idDiv).attr("strX"), $("div#" + idDiv).attr("strY"), $("div#" + idDiv).attr("lbl"), idSubDiv);
            });
        }
    });

    function showGraph(id, x, y, n, type) {
        $.post("assets/php/graph.php", function (data) {
            var strX = x != null ? x : "data";
            var strY = y != null ? y : "";
            var lbl = n != null ? n : "";
            var typeG = type != null ? type : "line";
            $("div.contenitore").html("");
            $("div.contenitore").append("<h2 id='bm2'><a href='#bm2'>Tabella con il " + lbl + "</a></h2><br><br>");
            console.log(data);
            console.log("id:" + id + " x:" + x + " y:" + y + " n:" + n + " type:" + type);
            var asseX = [];
            var asseY = [];
            var bColor = [];

            for (var i in data) {
                r = Math.floor(Math.random() * 200);
                g = Math.floor(Math.random() * 200);
                b = Math.floor(Math.random() * 200);
                c = 'rgb(' + r + ', ' + g + ', ' + b + ')';
                asseX.push(data[i][strX]);
                asseY.push(data[i][strY]);
                bColor.push(c);
            }

            var chartdata = {
                labels: asseX,
                datasets: [
                    {
                        label: lbl,
                        //backgroundColor: '#49e2ff',
                        backgroundColor: type != "line" && type !="radar" ? bColor : '#49e2ff',
                        //backgroundColor: bColor,
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#666666',
                        data: asseY
                    }
                ]
            };

            var graphTarget = $("#graphCanvas");

            graph = new Chart(
                graphTarget, {
                responsive: true,
                type: typeG,
                data: chartdata
            });
        });
        $(window.location).attr('href', '#bm2');
    }

    // $("div.contenitore").click(function(){
    //     $("nav#subnav").empty(); //svuoto la sub navigation bar
    //     $("div.contenitore").empty(); //svuoto il contenitore da possibili scritte
    //     if (graph != null) {
    //         graph.destroy();
    //     } //tolgo i grafici precedenti
    // });
});