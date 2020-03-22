$("document").ready(function () {
    $("nav div#1").click(function () {
        $.ajax({
            // definisco il tipo della chiamata
            type: "POST",
            // specifico la URL della risorsa da contattare
            url: "assets/php/show.php",
            // passo dei dati alla risorsa remota
            data: { "id": this.id},
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
    $("nav div#2").click(function () {
        showGraph();
    });

    function showGraph() {

        $.post("assets/php/graph.php",function (data) {
            console.log(data);
            var asseX = [];
            var asseY = [];

            for (var i in data) {
                asseX.push(data[i]["totale_attualmente_positivi"]);
                asseY.push(data[i]["totale_casi"]);
            }

            var chartdata = {
                labels: asseX,
                datasets: [
                    {
                        label: 'Totale dei casi',
                        backgroundColor: '#49e2ff',
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#666666',
                        data: asseY
                    }
                ]
            };

            var graphTarget = $("#graphCanvas");

            var barGraph = new Chart(graphTarget, {
                type: 'bar',
                data: chartdata
            });
        });
    }
});