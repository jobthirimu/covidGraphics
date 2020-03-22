$("document").ready(function(){
    showGraph();
});

function showGraph() {
    $.post("assets/php/data.php", { "url": $("#hidden").attr("title") }, function (data) {
        console.log(data);
        var asseX = [];
        var asseY = [];

        for (var i=0;i<443;i++) {
            if(i<10){
                console.log(data[i][tmp]);
                for(var tmp=0;tmp<64;tmp++){
                    if(tmp==1)
                    {
                        asseX.push(data[i][tmp]);
                    }else if (tmp==63){
                        asseY.push(data[i][tmp]);
                    }
                }
                
            }
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
            type: 'line',
            data: chartdata,
            options: {
                fill: false,
            }
        });
    });
}