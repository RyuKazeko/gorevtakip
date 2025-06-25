<?php
include "conn.php";

//$option = $_REQUEST["option"];
//$id = $_REQUEST["id"];

$option = "doesn't need to";
$id = 61;
try {
$query = "UPDATE tasks SET taskStatus=:taskStatus WHERE id = :id";
$prepared = $pdo->prepare($query);
$prepared->execute([
    "taskStatus"=> $option,
    "id" => $id
]);
echo "Görev durumu başarıyla değiştirildi";
} catch (PDOException $e) {
    echo "". $e->getMessage();
}