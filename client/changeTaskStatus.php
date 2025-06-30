<?php
include "conn.php";

$option = $_REQUEST["option"];
$id = $_REQUEST["id"];

switch ($option) {
    case "iptal":
        try {
            $query = "UPDATE tasks SET taskStatus=:taskStatus WHERE id = :id";
            $prepared = $pdo->prepare($query);
            $prepared->execute([
                "taskStatus" => $option,
                "id" => $id
            ]);
            if ($prepared) {
                echo "Görev durumu başarıyla değiştirildi";
            }
        } catch (PDOException $e) {
            echo "" . $e->getMessage();
        }

        break;

    case "tamamlandı":
        $date = date('Y/m/d h:i:s a', time());
        $report = $_REQUEST["report"];
        $query = "UPDATE tasks SET taskStatus=:taskStatus,dateComplete=:dateComplete, report=:report WHERE id = :id";
        $prepared = $pdo->prepare($query);
        $prepared->execute(["taskStatus" => $option, "dateComplete" => $date, "report" => $report]);
        if ($prepared) {
            echo "Görev tamamlandı. Tebrikler! Müthiş! Harikasınız!";
        } else {
            echo "İşlem Başarısız";
        }
        break;
}
