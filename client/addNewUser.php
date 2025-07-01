<?php
include "conn.php";
$newUser = $_REQUEST["userData"];
try {
    $query = "INSERT INTO users(name,role,mail,pass) VALUES (:name,:role,:mail,:pass)";
    $prep = $pdo->prepare($query);
    $result = $prep->execute(["name" => $newUser["name"], "role" => $newUser["role"], "mail" => $newUser["mail"], "pass" => $newUser["pass"]]);
    if ($result) {
        echo "Yeni kullanıcı başarıyla eklendi";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
