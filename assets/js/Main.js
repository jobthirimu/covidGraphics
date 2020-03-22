$("document").ready(function () {
    $("nav div").click(function () {
        $.ajax({
            // definisco il tipo della chiamata
            type: "POST",
            // specifico la URL della risorsa da contattare
            url: "assets/php/show.php",
            // passo dei dati alla risorsa remota
            data: {"id":this.id},
            // definisco il formato della risposta
            dataType: "html",
            // imposto un'azione per il caso di successo
            success: function (risposta) {
                $("#graphCanvas").html(risposta);
            },
            // ed una per il caso di fallimento
            error: function (err) {
            console.log(err);
            }
        })
        return false;
    });
});