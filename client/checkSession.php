<?php
session_start();
if (isset($_SESSION["currentLogin"])) {
    switch ($_SESSION["currentLogin"]["role"]) {
        case "admin":
            echo "admin.php";
            break;
        case "user":
            echo "user.php";
            break;
    }
} else {
    echo "failed";
}
