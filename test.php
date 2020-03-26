<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        * {
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>

    <nav class="navbar bg-dark navbar-dark">
        <a class="navbar-brand" href="#" id="home">Home</a>
        <div class="btn-group">
            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">Select a Country <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="#">Item I</a></li>
                <li class="dropdown-item"><a href="#">Item II</a></li>
                <li class="dropdown-item"><a href="#">Item III</a></li>
                <li class="dropdown-item"><a href="#">Item IV</a></li>
                <li class="dropdown-item"><a href="#">Item V</a></li>
                <li class="dropdown-item"><a href="#">Other</a></li>
            </ul>
        </div>
        <div class="btn-group">
            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">Select a Country <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="#">Item I</a></li>
                <li class="dropdown-item"><a href="#">Item II</a></li>
                <li class="dropdown-item"><a href="#">Item III</a></li>
                <li class="dropdown-item"><a href="#">Item IV</a></li>
                <li class="dropdown-item"><a href="#">Item V</a></li>
                <li class="dropdown-item"><a href="#">Other</a></li>
            </ul>
        </div>
        <div class="btn-group">
            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">Select a Country <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="#">Item I</a></li>
                <li class="dropdown-item"><a href="#">Item II</a></li>
                <li class="dropdown-item"><a href="#">Item III</a></li>
                <li class="dropdown-item"><a href="#">Item IV</a></li>
                <li class="dropdown-item"><a href="#">Item V</a></li>
                <li class="dropdown-item"><a href="#">Other</a></li>
            </ul>
        </div>
        <form class="form-inline">
            <button class="btn btn-outline-success" type="button">Main button</button>
        </form>
    </nav>
    <br>

    <div class="container">
        <h3>Test</h3>
        <p>testtest</p>
        <p>testtest</p>
        <p>testtest</p>
    </div>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $(".dropdown-menu li a").click(function() {
            var selText = $(this).text();
            $(this).parents('.btn-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
        });
        $("button").click(function() {
            alert("Hai cliccato");
        });
        $("#home").click(function() {
            location.reload();
        });
    </script>
</body>

</html>