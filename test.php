<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        .left-nav{
            height: 100%; /* 100% Full-height */
            width: 0; /* 0 width - change this with JavaScript */
            position: fixed; /* Stay in place */
            z-index: 1; /* Stay on top */
            top: 0; /* Stay at the top */
            left: 0;
            background-color: #111; /* Black*/
            overflow-x: hidden; /* Disable horizontal scroll */
        }
        .left-nav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            margin-left: 50px;
        }
        .container{
            background-color: yellow;
        }
    </style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="left-nav">
        <button type="button" class="closebtn"><i class="fa fa-close"></i></button>
        <p>IAUHDWIAUWEHDFAOWUIDFH</p>
        <div class="aggiorna">

        </div>
        <div class="nazionale">
            
        </div>
        <div class="provinciale">

        </div>
    </div>
    <div class="container">
        <p>Hey</p>
        <button type="button" id="mostra">Show</button>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        $("#mostra").click(function (){
            $(".left-nav").animate({
                width:'25%'
            });
        });
        $(".closebtn").click(function(){
            $(".left-nav").animate({
                width:'0%'
            });
        })
    </script>

</body>
</html>