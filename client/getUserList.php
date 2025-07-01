<?php
include "conn.php";

$query = "SELECT mail FROM users WHERE role = :role";
$result = $pdo->prepare($query);
$result->execute(["role" => "user"]);
$data = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
