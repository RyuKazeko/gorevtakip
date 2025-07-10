<?php
include_once "conn.php";
$taskId = $_REQUEST["taskId"];

$query = "SELECT report FROM tasks WHERE id=:id";
$prep = $pdo->prepare($query);
$prep->execute(["id" => $taskId]);
$result = $prep->fetch();
echo $result["report"];
