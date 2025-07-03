<?php
include "conn.php";
session_start();
$mail = $_SESSION["currentLogin"]["mail"];
//$mail = "atafanii@indiatimes.com";
$query = "SELECT * FROM tasks WHERE assignedTo = :mail";
$result = $pdo->prepare($query);
$result->execute(["mail" => $mail]);
$data = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
