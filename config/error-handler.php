<?php

require_once APP_ROOT . "logs/Logger.php";

set_exception_handler('exception_handler');

function exception_handler($exception) {
    if (is_subclass_of($exception, "CustomError")) {
        echo '<section class="error-message fade-out"><p>' . $exception->getMessage() . '</p></section>';
    } else {
        if ($_ENV["ENV"] == "PROD") {
            Logger::log($exception);
        } else {
            echo "<pre style=\"color: red;\">$exception</pre>";
        }
    }
}
