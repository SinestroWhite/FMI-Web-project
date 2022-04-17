<?php





session_start();
$curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);

if (isset($_SESSION["login_time"])) {
    switch ($curPageName) {
        case "login.php":
        case "register.php":
            header("Location: dashboard.php");
            break;
    }
} else {
    switch ($curPageName) {
        case "dashboard.php":
            header("Location: login.php");
            break;
    }
}
