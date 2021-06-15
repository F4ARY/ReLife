<?php
$dbhost = "localhost";
$dbuser = "db11581";
$dbpass = "eYNvuGqt";
$dbname = "db11581";

$dbuser = "root";
$dbpass = "";
$dbname = "relife";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn === false)
    die("Connection failed: " . $conn->connect_error);
