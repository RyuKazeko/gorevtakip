<?php

try {
    $dbhost = 'localhost';
    $dbname = 'gorevtakip';
    $dbuser = 'root';
    $dbpass = '';
    $pdo = new PDO(dsn: "mysql:host=$dbhost;dbname=$dbname", username: $dbuser, password: $dbpass);
} catch (PDOException $e) {
    echo "Error : " . $e->getMessage() . "<br/>";
    die();
}
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("MySQLi Bağlantı Hatası: " . $conn->connect_error);
}
