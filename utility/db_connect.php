<?php
$dbhost = "localhost";
//$dbuser = "db11581";
//$dbpass = "eYNvuGqt";
$dbname = "relife";

$dbuser = "root";
$dbpass = "";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn === false)
    die("Connection failed: " . $conn->connect_error);
