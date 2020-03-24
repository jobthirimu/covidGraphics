$("document").ready(function () {
    var barGraph;
    $("div#1").click(function () {
        if (barGraph != null) {
            barGraph.destroy();
        } //tolgo i grafici precedenti
        $("div.contenitore").html(""); //svuto contenitore
        $("div.contenitore").append("<h2>Aggiornamento in corso<br>Attendi un istante</h2><br><br>");
        $.ajax({
            // definisco il tipo della chiamata
            type: "POST",
            // specifico la URL della risorsa da contattare
            url: "assets/php/show.php",
            // passo dei dati alla risorsa remota
            data: { "id": this.id },
            // definisco il formato della risposta
            dataType: "html",
            // imposto un'azione per il caso di successo
            success: function (risposta) {
                $("div.contenitore").html(risposta);
            },
            // ed una per il caso di fallimento
            error: function (err) {
                console.log(err);
            }
        })
        return false;
    });
    $("nav div").click(function () {
        if (this.id != 1) {
            showGraph(this.id);
        }
    });

    function showGraph(id) {
        $("div.contenitore").empty(); //svuoto il contenitore da possibili scritte
        if (barGraph != null) {
            barGraph.destroy();
        } //tolgo i grafici precedenti
        $.post("assets/php/graph.php", function (data) {
            var strX = "data";
            var strY = "";
            var lbl = "";
            var typeG = "line";
            if (id == 2) {
                strY = "totale_casi";
                lbl = "Totale dei casi"
            } if (id == 3) {
                strY = "totale_attualmente_positivi";
                lbl = "Totale Infetti"
            } if (id == 4) {
                strY = "nuovi_attualmente_positivi";
                lbl = "Nuovi Infetti"
            } if (id == 5) {
                strY = "dimessi_guariti";
                lbl = "Totale Guariti"
            } if (id == 6) {
                strY = "deceduti";
                lbl = "Totale Morti"
            }
            $("div.contenitore").html("");
            $("div.contenitore").append("<h2 id='bm2'><a href='#bm2'>Tabella con il " + lbl + "</a></h2><br><br>");
            console.log(data);
            var asseX = [];
            var asseY = [];

            for (var i in data) {
                asseX.push(data[i][strX]);
                asseY.push(data[i][strY]);
            }

            var chartdata = {
                labels: asseX,
                datasets: [
                    {
                        label: lbl,
                        backgroundColor: '#49e2ff',
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#666666',
                        data: asseY
                    }
                ]
            };

            var graphTarget = $("#graphCanvas");

            barGraph = new Chart(
                graphTarget, {
                responsive: true,
                type: typeG,
                data: chartdata
            });
        });
        $(window.location).attr('href', '#bm2');
    }
});