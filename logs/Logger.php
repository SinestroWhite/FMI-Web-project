<?php

/*
|--------------------------------------------------------------------------
| Logger
|--------------------------------------------------------------------------
|
| Logger class logs errors in a log file.
|
*/

class Logger {

    public static function log(string $message, string $file = APP_ROOT . "logs/errors.log") {
        $log_file = fopen($file, "a");

        if (!$log_file) {
            throw new FileOpenError();
        }

        fwrite($log_file, $message . "\n");
        fclose($log_file);
    }
}
