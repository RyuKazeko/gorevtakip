<?php

include("conn.php");

$mail = $_REQUEST["mail"];
$pass = $_REQUEST["password"];

if(checkUserExist($pdo,$mail)) {
$queryPass = "SELECT password FROM users WHERE mail = :mail";
$prepared = $pdo->prepare($queryPass);
$prepared->execute([":mail"=> $mail]);
$passResult->fetch();
if(password_verify($pass, $passResult["password"])) {
    echo "vertified";
} else {
    echo "wrong pass";
}
}else{
    echo "not found";
}


function checkUserExist($pdo, $mail)
{
    $queryMail = "SELECT mail FROM users WHERE mail = :mail";
    $prepared = $pdo->prepare($queryMail);
    try {
        $prepared->execute([
            ":mail" => $mail,
        ]);
        if($prepared->rowCount() > 0) {
            return true;
        }
        else{
            return false;
        }
        
    } catch (PDOException $e) {
        return false;
    }
}
