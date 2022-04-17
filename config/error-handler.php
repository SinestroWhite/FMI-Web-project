<?php

require_once APP_ROOT . "logs/Logger.php";

set_exception_handler('exception_handler');

function exception_handler($exception) {
    if (is_subclass_of($exception, "CustomError")) {
        echo $exception->getMessage(), "\n";
    } else {
        Logger::log($exception);
    }
}
