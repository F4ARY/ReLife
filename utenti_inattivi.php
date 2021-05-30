<?php

include_once("utility/db_connect.php");
session_start();

if(!isset($_SESSION['id_dipendente'])){
    header("location: login.php");
    exit();
}
?>
<html>

<head>
    <title>Utenti inattivi</title>
    <style>
        @charset "UTF-8";
        @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,700);

        body {
            font-family: 'Open Sans', sans-serif;
            font-weight: 300;
            line-height: 1.42em;
            color: #A7A1AE;
            background-color: #1F2739;
        }

        h1 {
            font-size: 3em;
            font-weight: 300;
            line-height: 1em;
            text-align: center;
            color: #4DC3FA;
        }

        h2 {
            font-size: 1em;
            font-weight: 300;
            text-align: center;
            display: block;
            line-height: 1em;
            padding-bottom: 2em;
            color: #FB667A;
        }

        h2 a {
            font-weight: 700;
            text-transform: uppercase;
            color: #FB667A;
            text-decoration: none;
        }

        .container th h1 {
            font-weight: bold;
            font-size: 1em;
            text-align: left;
            color: #185875;
        }

        .container td {
            font-weight: normal;
            font-size: 1em;
            -webkit-box-shadow: 0 2px 2px -2px #0E1119;
            -moz-box-shadow: 0 2px 2px -2px #0E1119;
            box-shadow: 0 2px 2px -2px #0E1119;
        }

        .container {
            text-align: left;
            overflow: hidden;
            width: 80%;
            margin: 0 auto;
            display: table;
            padding: 0 0 8em 0;
        }

        .container td,
        .container th {
            padding-bottom: 2%;
            padding-top: 2%;
            text-align: center;
        }

        .container tr:nth-child(odd) {
            background-color: #323C50;
        }

        .container tr:nth-child(even) {
            background-color: #2C3446;
        }

        .container th {
            background-color: #1F2739;
        }

        .container td:first-child {
            color: #FB667A;

        }

        .container tr:hover {
            background-color: #464A52;
            -webkit-box-shadow: 0 6px 6px -6px #0E1119;
            -moz-box-shadow: 0 6px 6px -6px #0E1119;
            box-shadow: 0 6px 6px -6px #0E1119;
        }

        .container td:hover {
            background-color: #FFF842;
            color: #403E10;
            font-weight: bold;

            box-shadow: #7F7C21 -1px 1px, #7F7C21 -2px 2px, #7F7C21 -3px 3px, #7F7C21 -4px 4px, #7F7C21 -5px 5px, #7F7C21 -6px 6px;
            transform: translate3d(6px, -6px, 0);

            transition-delay: 0s;
            transition-duration: 0.4s;
            transition-property: all;
            transition-timing-function: line;
        }

        .accetta{
            border-radius: 100%;
            border: none;
            height: 40px;
            width: 40px;
            font-size: 170%;
            background-color: rgb(0, 199, 0);
            color: white;
            cursor: pointer;
        }

        .rifiuta{
            border-radius: 100%;
            border: none;
            cursor: pointer;
            height: 40px;
            width: 40px;
            font-size: 170%;
            background-color: rgb(199, 0, 0);
            margin-left: 40px;
            color: white;
        }

        img{
            border: 5px #FFF842 solid;
        }

        @media (max-width: 800px) {

            .container td:nth-child(4),
            .container th:nth-child(4) {
                display: none;
            }
        }
    </style>
</head>

<body>

<h1>Tabella utenti inattivi</h1>
<h2>Questi utenti non hanno mai caricato immagini</h2>
<h2>Hai fatto l'accesso con l'ID: <b><?php echo $_SESSION['id_dipendente']?></b> | <a href="logout.php"><b>Logout</b></a> | <a href="verifiche.php"><b>Verifiche Dipendenti</b></a></h2>

<table class = "container">
    <thead>
    <tr>
        <th>
            <h1>Nome</h1>
        </th>
        <th>
            <h1>Cognome</h1>
        </th>
        <th>
            <h1>Email</h1>
        </th>
        <th>
            <h1>Username</h1>
        </th>
    </tr>
    </thead>
    <tbody
    <?php

    $query = "SELECT * FROM re_utenti LEFT JOIN re_foto ON re_utenti.id_utente = re_foto.id_utente where re_foto.id_utente IS NULL";
    $ris = $conn->query($query);

    while ($riga = $ris->fetch_assoc()){
        $email = $riga['email'];
        $nome = $riga['nome'];
        $cognome = $riga['cognome'];
        $username = $riga['username'];

        echo '<tr>
        <td>' . $nome . '</td>
        <td>' . $cognome . '</td>
        <td>' . $email . '</td>
        <td>' . $username . '</td>
    </tr>';
    }
    ?>

    </tbody>
</table>
</body>

</html>