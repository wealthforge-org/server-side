<?php
$ServerName = "localhost";
$username = "root";
$password = "";
$dbName = "wealthforgedb";

$conc = new mysqli($ServerName, $username, $password, $dbName);

if ($conc->connect_error) {
    die("Connection failed: " . $conc->connect_error);
}
