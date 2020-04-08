<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link p-2 text-center" href="index.php" rel="noopener">
                        <i class="fas fa-home"></i>&nbspHome
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link p-2 text-center" href="MainStatistiche.php" rel="noopener">
                        <i class="fas fa-chart-line"></i>&nbspStatistiche
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link p-2 text-center" href="MainGrafici.php" rel="noopener">
                        <i class="fas fa-chart-pie"></i>&nbspGrafici
                    </a>
                </li>
            </ul>
            <a class="nav-link p-2 text-center ml-auto" href="https://github.com/mzanrosso/covidGraphics" target="_blank" rel="noopener">
                <i style="color: #CCC" class="fab fa-github"></i>
            </a>
            <div class="dropdown-divider"></div>
            <form class="" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <div class="input-group">
                    <input type="hidden" name="cmd" value="_s-xclick" />
                    <input type="hidden" name="hosted_button_id" value="HPDFHTWTG7QCE" />
                    <input class="" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" title="Grazie per il tuo supporto!" alt="Fai una donazione con il pulsante PayPal" />
                    <img alt="" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1" />
                </div>
            </form>
        </div>
    </nav>
    <div class="jumbotron jumbotron-fluid p-10">
        <h1 class="display-4">COVID-19 Info</h1>
        <p class="lead">Il sito per i grafici e le statistiche sul covid-19</p>
        <hr class="my-4">
        <!-- <p>Seleziona il servizio</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Grafici</a>
        <a class="btn btn-primary btn-lg" href="#" role="button">Statistice</a> -->
    </div>
    <footer class="page-footer font-small blue pt-4">
        <div class="footer-copyright text-center py-3">
            Created by Marco Zanrosso and Giacomo Coluccelli©
        </div>
    </footer>
    <script src="https://kit.fontawesome.com/7a2d9896bf.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>