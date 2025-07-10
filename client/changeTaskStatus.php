<?php
include "conn.php";
session_start();
$option = $_REQUEST["option"];
$id = $_REQUEST["id"];
$mail = $_SESSION["currentLogin"]["mail"];
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
        try {
            $date = date('Y/m/d h:i:s a', time());
            $report = $_REQUEST["report"];
            $query = "UPDATE tasks SET taskStatus=:taskStatus,dateComplete=:dateComplete, report=:report WHERE id = :id";
            $prepared = $pdo->prepare($query);
            $prepared->execute(["taskStatus" => $option, "dateComplete" => $date, "report" => $report, "id" => $id]);
        } catch (PDOException $e) {
            echo "" . $e->getMessage();
        }

        if ($prepared) {
            try {
                $QcheckDoneCount = "SELECT name FROM users WHERE mail =:mail";
                $QcheckDone = $pdo->prepare($QcheckDoneCount);
                $QcheckDone->execute([
                    "mail" => $mail
                ]);
                $DoneCount = $QcheckDone->rowCount();
            } catch (PDOException $e) {
                echo "" . $e->getMessage();
            }
            try {
                $QupdateDoneCount = "UPDATE users SET tasksDone = :doneCount WHERE mail=:mail";
                $updateDone = $pdo->prepare($QupdateDoneCount);
                $updateDone->execute(["doneCount" => $DoneCount, "mail" => $mail]);
                echo "Görev tamamlandı. Tebrikler! Müthiş! Harikasınız!";
            } catch (PDOException $e) {
                echo "" . $e->getMessage();
            }
        } else {
            echo "İşlem Başarısız";
        }
        break;
}
