<?php
include "conn.php";
/*
$title = $_REQUEST["something"];
$assigner = $_REQUEST["something"];
$assignedTo = $_REQUEST["something"];
$details = $_REQUEST["something"];
$status = $_REQUEST["something"];
$dateStart = $_REQUEST["something"];
$dateEnd = $_REQUEST["something"];
*/
$title = "a title";
$assigner = "an assigner";
$assignedTo = "assingedto";
$details = "details";
$taskStatus = "taskStatus";
$dateStart = date("d-m-Y H:i:s");;
$dateEnd = date("d-m-Y H:i:s");;
try {
$query = "INSERT INTO tasks (title, assigner, assignedTo,details,taskStatus,dateStart,dateEnd) VALUES (:title, :assigner, :assignedTo, :details, :taskStatus, :dateStart, :dateEnd)";
$prepared = $pdo->prepare($query);
$executed = $prepared->execute(params: [
    "title"=> $title,
    "assigner"=> $assigner,
    "assignedTo"=> $assignedTo,
    "details"=> $details,
    "taskStatus"=> $taskStatus,
    "dateStart"=> $dateStart,
    "dateEnd"=> $dateEnd
]);
} catch (PDOException $e) {
    echo $e;
}