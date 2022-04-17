<?php

/*
|--------------------------------------------------------------------------
| Logger
|--------------------------------------------------------------------------
|
| Logger class logs errors in a log file.
|
*/

require_once("../FileSaveError.php");

class Logger {

    public static function log(string $message, string $file = "/logs/errors.log") {
        $log_file = fopen($_SERVER["DOCUMENT_ROOT"] . $file, "a");

        if (!$log_file) {
            throw new FileSaveError();
        }

        fwrite($log_file, $message . "\n");
        fclose($log_file);
    }
}
