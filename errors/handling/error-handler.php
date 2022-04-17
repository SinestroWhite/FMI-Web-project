<?php

require_once("logger.php");

set_exception_handler('exception_handler');

function exception_handler($exception) {
    if (is_subclass_of($exception, "Error")) {
        echo $exception->getMessage(), "\n";
    } else {
        Logger::log($exception);
    }
}
