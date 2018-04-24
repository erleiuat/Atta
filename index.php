<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Simple Weight-Manager for easy and fast loss of weight">
        <meta name="author" content="Elia Reutlinger">

        <title>Atta - Simple & Fast weight loss</title>

        <!-- Bootstrap core CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

        <!-- Custom fonts for this template -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

        <!-- Custom styles for this template -->
        <link href="css/resume.min.css" rel="stylesheet">

    </head>

    <body id="page-top">

        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <span class="d-block d-lg-none">Atta</span>
                <span class="d-none d-lg-block">
                    <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="img/profile.jpg" alt="">
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <?php

                        include("include/database.php");
                        include("include/session.php");

                        if($session_loggedin){
                            $data = $mysqli->query("SELECT * FROM `tb_modul` WHERE `secured` is true");
                        } else {
                            $data = $mysqli->query("SELECT * FROM `tb_modul` WHERE `secured` is false");
                        }

                        if (isset($data) && $data->num_rows > 0) {
                            while($row = $data->fetch_assoc()) {

                                echo '
                                <li class="nav-item">
                                    <a class="nav-link js-scroll-trigger" href="'.$row['url'].'">'.$row['title'].'</a>
                                </li>
                                ';

                            }
                        }

                    ?>
                </ul>
            </div>
        </nav>

        <div class="container-fluid p-0">
            <?php

                if($session_loggedin){
                    if(isset($_GET['page']) && $_GET['page'] != ""){
                        $pageLink = "modul/".$_GET['page'].".php";
                    } else if(isset($_SESSION["user"]["currentPath"])){
                        $pageLink = $_SESSION["user"]["currentPath"];
                    } else {
                        $pageLink = "modul/dashboard/dashboard.php";
                    }
                } else {
                    $pageLink = "modul/login/login.php";
                }


            ?>
            <div page="<?php echo $pageLink; ?>" id="pageContent"></div>
        </div>

        <!-- Bootstrap core JavaScript -->
        <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js" integrity="sha384-lZmvU/TzxoIQIOD9yQDEpvxp6wEU32Fy0ckUgOH4EIlMOCdR823rg4+3gWRwnX1M" crossorigin="anonymous"></script>

        <!-- Plugin JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha256-H3cjtrm/ztDeuhCN9I4yh4iN2Ybx/y1RM7rMmAesA0k=" crossorigin="anonymous"></script>

        <!-- Custom scripts for this template -->
        <script src="js/resume.min.js"></script>
        <script type="text/javascript" src="js/index.min.js"></script>

    </body>

</html>
