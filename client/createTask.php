<?php
session_start();
include "conn.php";
$taskData = $_REQUEST["taskData"];
$assigner = $_SESSION["currentLogin"]["mail"];
print_r($taskData);

try {
    $query = "INSERT INTO tasks (title, assigner, assignedTo,details,taskStatus,dateStart,dateEnd) VALUES (:title, :assigner, :assignedTo, :details, :taskStatus, :dateStart, :dateEnd)";
    $prepared = $pdo->prepare($query);
    $executed = $prepared->execute(params: [
        "title" => $taskData["title"],
        "assigner" => $assigner,
        "assignedTo" => $taskData["assignedTo"],
        "details" => $taskData["details"],
        "taskStatus" => "Devam etmekte",
        "dateStart" => $taskData["dateStart"],
        "dateEnd" => $taskData["dateEnd"],
    ]);
    echo $taskData["title"], " görevi başarıyla ", $taskData["assignedTo"], " kişisine başarıyla atandı";
} catch (PDOException $e) {
    echo $e;
}
