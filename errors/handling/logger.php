<?php

function logger(string $message) {
    // TODO: remove die
    $log_file = fopen($_SERVER['DOCUMENT_ROOT'] . "/logs/errors.log", "a") or die("Unable to open file!");
    fwrite($log_file, $message . "\n");
    fclose($log_file);
}
