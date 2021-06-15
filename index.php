<?php
session_start();
include_once("utility/db_connect.php");

if(!isset($_SESSION['id'])){
    header("Location: login.php");
}

if(isset($_POST['caricamento'])){
    $UploadDir = "imgs/";
    $nomeFile = $_FILES['foto']['name'] . rand(0, 10000) .".jpg";
    move_uploaded_file($_FILES['foto']['tmp_name'], $UploadDir . $nomeFile);
    $data = date('Y-m-d');
    $current_id = $_SESSION['id'];

    $query = "INSERT INTO re_foto (data_caricamento, file_name, id_utente) VALUES ('$data', '$nomeFile', $current_id)";
    $conn->query($query) or die($conn->error);
    header("location: index.php");
    exit();
}

if(isset($_POST['commenta'])){
    $data = date('Y-m-d');
    $current_id = $_SESSION['id'];
    $commento = $_POST['comment'];
    $fotoId = $_POST['photo_id'];
    $query = "INSERT INTO `re_commenti` (`data`, `commento`, `id_utente`, `id_foto`) VALUES ('$data', '$commento', $current_id, '$fotoId')";
    $conn->query($query) or die($conn->error);
    header("location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>HomePage</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css'>
    <link rel="stylesheet" href="./style.css">

    <style>
        html {
            background-color: #1F2739;
        }

        body {
            padding: 100px 0;
            background-color: #1F2739;
        }

        .card {
            margin-bottom: 30px;
        }

        .btn,
        .btn:focus {
            outline: none;
            box-shadow: none;
        }

        .card2 {
            margin-right: 20px;
            border: 0;
            border-radius: 15px 15px 15px 15px;
            box-shadow: 0px 5px 10px -5px rgba(0, 0, 0, 0.75);
            text-align: center;
        }

        .card2 .card-img {
            border-radius: 15px 0 0 0;
            -o-object-fit: cover;
            object-fit: cover;
        }

        .card2 .card-socials {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            position: absolute;
            top: 20px;
            right: -20px;
            z-index: 1;
        }

        .card2 .card-socials a {
            display: block;
            border-radius: 15px 0 15px 0;
            width: 80px;
            height: 80px;
            background: #05668D;
            color: #ffffff;
            line-height: 40px;
            text-align: center;
            transition: 0.3s;
        }

        .card2 .card-socials button {
            display: block;
            border-radius: 15px 0 15px 0;
            width: 80px;
            height: 80px;
            background: #05668D;
            color: #ffffff;
            line-height: 40px;
            text-align: center;
            transition: 0.3s;
            border: none;
            margin-top: 20px;
        }

        .card2 .card-socials a:not(:last-of-type) {
            margin-bottom: 10px;
        }

        .card2 .card-socials a:hover {
            background: #028090;
            transform: scale(1.15);
        }

        .card2 .card-socials button:hover {
            background: #028090;
            transform: scale(1.15);
        }

        .caricamento{
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background-color: #028090;
            border: none;
            border-radius: 100%;
        }
    </style>

</head>

<body style="padding: 0;">

<button class="caricamento" data-toggle="modal" data-target="#modaleCaricamento">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16" style="color: white;">
        <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
    </svg>
</button>

<!-- MODALE CARICAMENTO FOTO -->
<div class="modal fade" id="modaleCaricamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form name="sign-up" action="index.php" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Carica un&apos; immagine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="upload-image" type="file" name="foto" id="picture" accept="image/jpeg, image/png" required="">
                    <input type="hidden" value="1" name="caricamento">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-primary">Carica</button>
                </div>
        </form>
    </div>
</div>
</div>

<!--FINE MODALE-->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">ReLife</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
        </div>
    </div>
    <a href="logout.php" class="btn btn-primary">Logout</a>
</nav>

<main style="margin-top: 50px;">
    <div class="container">

        <div class="row">

            <?php

            $query = "SELECT * FROM re_foto";
            $ris = $conn->query($query);

            while ($riga = $ris->fetch_assoc()){
                 echo ' <!--FOTO-->

            <!-- MODALE INFORMAZIONI COMMENTI-->
            <div class="modal fade" id="modCommenti' . $riga['id_foto'] . '" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Commenti</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="sezioneCommenti">';

                 $query = "SELECT * FROM re_commenti WHERE id_foto = " . $riga['id_foto'];

                 $ris2 = $conn->query($query);

                 while ($riga2 = $ris2->fetch_assoc()){
                     $datiPersona = $conn->query("SELECT * FROM re_utenti WHERE id_utente = " . $riga2['id_utente'])->fetch_assoc();

                     echo '<div class="row" style="margin-bottom: 20px;">
                                    <div class="col-2" style="text-align: center;">
                                        <span><b>' . $datiPersona['nome'] . " " . $datiPersona['cognome'] .'</b></span>
                                    </div>
                                    <div class="col-9">
                                        <span>' . $riga2['commento'] . '</span>
                                    </div>
                                </div>';
                 }
                 if($ris2->num_rows == 0) echo "<span>Non ci sono ancora commenti. Fai partire la conversazione!</span>";

                 $queryUtente = "SELECT * FROM re_utenti WHERE id_utente = " . $riga['id_utente'];

                 $utente = $conn->query($queryUtente)->fetch_assoc();

                 echo '<div class="row">
                                    <form action="index.php" id="form_commenta" method="post" style="padding: 10px;">
                                        <input type="textbox" name="comment" style="width: 75%;">
                                        <input type="hidden" name="photo_id" value="' . $riga['id_foto'] . '">
                                        <input type="hidden" name="commenta" value="1">
                                        <input class="btn btn-primary" type="submit" name="commenta" value="Commenta" style="margin-top: 20px;">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fine modale-->

            <div class="col-sm-6 col-lg-6">
                <div class="card card2">
                    <div class="card-img embed-responsive embed-responsive-4by3">
                        <img src="imgs/' . $riga['file_name'] . '" alt="#"
                             class="card-img embed-responsive-item" style="height: 400px;">
                    </div>
                    <div class="card-socials">

                        <button type="submit" data-toggle="modal" data-target="#modCommenti' . $riga['id_foto'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                                                                  fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                                <path
                                    d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z" />
                            </svg></button>
                    
                    </div>
                    <span>' . $utente['nome'] . " " . $utente['cognome'] . '</span>
                </div>

            </div>
            <!--FINE FOTO-->';
            }

            ?>

        </div>
    </div>


    </footer>
    <!-- Footer -->
</main>
<!-- partial -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js'></script>
</body>

</html>
