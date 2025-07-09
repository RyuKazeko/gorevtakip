<?php
include "conn.php";
$newUser = $_REQUEST["user"];

if (checkIfExist($pdo, $newUser)) {
    echo "exists";
} else {
    addNewUser($pdo, $newUser);
}
function checkIfExist($pdo, $newUser)
{
    $Qcheck = "SELECT * FROM users WHERE mail = :mail";
    $prep = $pdo->prepare($Qcheck);
    $prep->execute([
        "mail" => $newUser["NewUserEmail"]
    ]);
    $result = $prep->fetchAll();
    if (count($result) > 0) {
        return true;
    } else {
        return false;
    }
}
function addNewUser($pdo, $newUser)
{
    try {
        $mdPass = password_hash(password: $newUser["NewUserPassword"], algo: PASSWORD_DEFAULT);
        $query = "INSERT INTO users(name,role,mail,pass) VALUES (:name,:role,:mail,:pass)";
        $prep = $pdo->prepare($query);
        $result = $prep->execute(["name" => $newUser["NewUserName"], "role" => "user", "mail" => $newUser["NewUserEmail"], "pass" => $mdPass]);
        if ($result) {
            echo "Yeni kullanıcı başarıyla eklendi";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
