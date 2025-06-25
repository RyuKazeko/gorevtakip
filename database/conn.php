<?php
date_default_timezone_set("Turkey");
try {
        $dbhost = 'localhost';
        $dbname='gorevtakip';
        $dbuser = 'root';
        $dbpass = '';
        $pdo = new PDO(dsn: "mysql:host=$dbhost;dbname=$dbname", username: $dbuser, password: $dbpass);
    }
   catch (PDOException $e) {
        echo "Error : " . $e->getMessage() . "<br/>";
        die();
    }
?>
