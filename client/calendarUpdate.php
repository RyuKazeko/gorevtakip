<?php
include "conn.php";
$dateStart = $_REQUEST["dateStart"];
$dateEnd = $_REQUEST["dateEnd"];
$id = $_REQUEST["id"];

echo $dateEnd;

$query = "UPDATE tasks SET dateStart = :dateStart, dateEnd =:dateEnd WHERE id=:id";
$prepped = $pdo->prepare($query);
$prepped->execute([":id"=> $id,":dateStart"=> $dateStart,":dateEnd"=> $dateEnd]);
