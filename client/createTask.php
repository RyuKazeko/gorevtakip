<?php
session_start();
include "conn.php";
/*
$title = $_REQUEST["something"];
$assigner = $_REQUEST["something"];
$assignedTo = $_REQUEST["something"];
$details = $_REQUEST["something"];
$status = $_REQUEST["something"];
$dateStart = $_REQUEST["something"];
$dateEnd = $_REQUEST["something"];

$title = "a title";
$assigner = "an assigner";
$assignedTo = "assingedto";
$details = "details";
$taskStatus = "taskStatus";
$dateStart = date("d-m-Y H:i:s");;
$dateEnd = date("d-m-Y H:i:s");;
*/
$taskData =$_REQUEST["taskData"];
$assigner = $_SESSION["currentLogin"]["mail"];
print_r( $taskData);

try {
$query = "INSERT INTO tasks (title, assigner, assignedTo,details,taskStatus,dateStart,dateEnd) VALUES (:title, :assigner, :assignedTo, :details, :taskStatus, :dateStart, :dateEnd)";
$prepared = $pdo->prepare($query);
$executed = $prepared->execute(params: [
    "title"=> $taskData["title"],
    "assigner"=> $assigner,
    "assignedTo"=> $taskData["assignedTo"],
    "details"=> $taskData["details"],
    "taskStatus"=> $taskData["taskStatus"],
    "dateStart"=> $taskData["dateStart"],
    "dateEnd"=> $taskData["dateEnd"],
]);
echo $taskData["title"]," görevi başarıyla ", $taskData["assignedTo"]," kişisine başarıyla atandı";
} catch (PDOException $e) {
    echo $e;
}
