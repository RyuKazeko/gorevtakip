<?php
session_start();
include "conn.php";
$mail = $_REQUEST['mail'];

try {
    $_SESSION["currentLogin"] = getInfo($pdo, $mail);

    switch ($_SESSION["currentLogin"]["role"]) {
        case "admin":
            echo "admin.php";
            break;
        case "user":
            echo "user.html";
            break;
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}


function getInfo($pdo, $mail)
{
    $query = "SELECT * FROM users WHERE mail=:mail";
    $prep = $pdo->prepare($query);
    $prep->execute([":mail" => $mail]);
    $result = $prep->fetch(PDO::FETCH_ASSOC);
    return $result;
}
