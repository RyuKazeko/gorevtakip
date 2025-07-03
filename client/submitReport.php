<?php
session_start();
include "conn.php";
$report = $_REQUEST["report"];
$id = $_REQUEST["taskid"];

$query = "UPDATE tasks SET report = :report WHERE id=:id";
try {
    $prep = $pdo->prepare($query);
    $prep->execute([
        "report" => $report,
        "id" => $id
    ]);
    if ($prep) {
        echo $prep->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
