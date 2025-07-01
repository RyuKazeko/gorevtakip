<?php
include "conn.php";
$newUser = $_REQUEST["user"];
try {
    $mdPass = password_hash($newUser["NewUserPassword"], PASSWORD_DEFAULT);
    $query = "INSERT INTO users(name,role,mail,pass) VALUES (:name,:role,:mail,:pass)";
    $prep = $pdo->prepare($query);
    $result = $prep->execute(["name" => $newUser["NewUserName"], "role" => "user", "mail" => $newUser["NewUserEmail"], "pass" => $mdPass]);
    if ($result) {
        echo "Yeni kullanıcı başarıyla eklendi";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
