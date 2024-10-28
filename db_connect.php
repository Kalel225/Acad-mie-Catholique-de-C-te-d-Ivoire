<?php
$host = 'localhost';
$dbname = 'mon_project';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}
?>
