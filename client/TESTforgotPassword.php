<?php
include("conn.php");
$mail = $_REQUEST["mail"];

$query = "SELECT mail FROM users WHERE mail = :mail";
$search = $pdo->prepare($query);
$search->execute(["mail" => $mail]);
$result = $search->fetchAll(PDO::FETCH_ASSOC);
if (isset($result[0])) {
    //Send code to email
} else {
    //say user doesn't exist
}
