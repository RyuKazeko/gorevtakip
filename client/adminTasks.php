<?php
include("conn.php");

//$mail = $_REQUEST["mail"];
$mail = "atafanii@indiatimes.com";
$query = "SELECT * FROM tasks WHERE assigner = :mail";
$result = $pdo->prepare($query);
$result->execute( ["mail"=> $mail]);
$data =$result->fetchAll();
echo json_encode($data);