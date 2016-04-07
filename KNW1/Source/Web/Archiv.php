<?php
    include '../Classes/Methods.php';
    $methods = new Methods();

    $panoramaPictures = scandir('../../Image/Archiv');

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Panorama/Archiv</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/3-col-portfolio.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Aktuell</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="Archiv.php">Archiv</a>
                    </li>
                    <li>
                        <a href="About.php">About</a>
                    </li>
                    <li>
                        <a href="Contact.php">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Archiv
                    <small>Panoramabilder</small>
                </h1>
                <br><br><br>
            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->
        <?php
        if(!empty($_GET['day']))
        {
            $files = $methods->SearcheForSelectedDateInFileArray($_GET['day']);

            if($files == null)
            {
                echo '<h1>Noch keine Bilder im Archiv.</h1>';
                echo '<br>';
                echo '<h1>Schau dir das aktuelle Bild an.</h1>';
            }
            else
            {
                foreach ($files as $picture) {

                    echo "<div class='row'>
                    <div>
                        <a href='../../Image/Archiv/" . $picture . "'>
                        <img class='img-responsive' src = '../../Image/Archiv/" . $picture . "' alt=''>
                        </a>
                        <p>Datum: " . date("d.m.Y H:i  ", filemtime('../../Image/Archiv/' . $picture . '.')) . " </p>
                    </div>
                    </div>";
                }
            }
        }
        else
        {
            echo "<h2>Geben Sie bitte ein Datum und Uhrzeit an und clicken Sie anschliessend auf Senden.</h2>";
        }
        ?>
        <br>
        <form action="Archiv.php" method="get">
            <input type="datetime-local" name="day">
            <input type="submit" >
        </form>
        <!-- /.row -->
        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Oliver Czabala</p>
                    <ul class="list-unstyled">
                        <li>Bootstrap v3.3.6</li>
                        <li>jQuery v1.11.1</li>
                    </ul>
                </div>
            </div>
            <!-- /.row -->
        </footer>
        <!-- jQuery Version 1.11.1 -->
        <script src="../../js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../../js/bootstrap.min.js"></script>
    </div>
    <!-- /.container -->



</body>

</html>
