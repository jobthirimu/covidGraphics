$("document").ready(function () {
    var barGraph;
    $("div#1").click(function () {
        if (barGraph != null) {
            barGraph.destroy();
        } //tolgo i grafici precedenti
        $("div.contenitore").html(""); //svuto contenitore
        $("nav#subnav").html("<div id='tutto'>Aggiorna tutti i dati</div><div id='naz'>Aggiorna dati nazionali</div><div id='reg'>Aggiorna dati regionali</div><div id='prov'>Aggiorna dati provinciali</div>");
        $("nav#subnav div").click(function () {
            if (barGraph != null) {
                barGraph.destroy();
            } //tolgo i grafici precedenti
            $("div.contenitore").html(""); //svuto contenitore
            $("div.contenitore").append("<h2>Aggiornamento in corso<br>Attendi un istante</h2><br><br>");
            $.ajax({
                // definisco il tipo della chiamata
                type: "POST",
                // specifico la URL della risorsa da contattare
                url: "assets/php/update.php",
                // passo dei dati alla risorsa remota
                data: { "id": this.id},
                // definisco il formato della risposta
                dataType: "html",
                // imposto un'azione per il caso di successo
                success: function (risposta) {
                    $("div.contenitore").html("<h3>"+risposta+"</h3>");
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
        var idDiv=this.id;
        if (this.id != 1) {
            showGraph(idDiv, $("div#" + idDiv).attr("strX"), $("div#" + idDiv).attr("strY"), $("div#" + idDiv).attr("lbl"), $("div#" + idDiv).type);
        }
    });

    function showGraph(id,x,y,n,type) {
        $("div.contenitore").empty(); //svuoto il contenitore da possibili scritte
        if (barGraph != null) {
            barGraph.destroy();
        } //tolgo i grafici precedenti

        $.post("assets/php/graph.php", function (data) {
            var strX = x != null ? x : "data" ;
            var strY = y != null ? y : "";
            var lbl = n != null ? n : "";
            var typeG = type != null ? type : "line";
            $("div.contenitore").html("");
            $("div.contenitore").append("<h2 id='bm2'><a href='#bm2'>Tabella con il " + lbl + "</a></h2><br><br>");
            console.log(data);
            console.log("id:" + id + " x:" + x + " y:" + y + " n:" + n + " type:" + type);
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