<?php
ini_set("mssql.textlimit" , "2147483647");
ini_set("mssql.textsize" , "2147483647");
ini_set("odbc.defaultlrl", "100K    ");

session_start();
include_once("utility/db_connect.php");
$id = $_GET['id'];

$sql = 'SELECT * FROM re_utenti WHERE id_utente = "'. $id .'"';
$risultato = $conn->query($sql);

$riga = $risultato->fetch_assoc();

$image = $riga['documento'];
header('Content-Type: image/jpeg');
echo $image;
?>