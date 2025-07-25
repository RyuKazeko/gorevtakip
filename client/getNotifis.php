<?php
include "conn.php";
session_start();

$uid = $_SESSION["currentLogin"]["id"];
//$mail = "atafanii@indiatimes.com";
$query = "SELECT * FROM notifi WHERE userID = :userID";
$result = $pdo->prepare($query);
$result->execute(["userID" => $uid]);
$data = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
