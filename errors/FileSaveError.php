<?php

/*
|--------------------------------------------------------------------------
| BigBlueButtonParser Save Error
|--------------------------------------------------------------------------
|
| This error is thrown when a file cannot be written on the disk.
|
*/

class FileSaveError extends CustomError {
    public function __construct() {
        parent::__construct("There was a technical problem and the file could not be saved.");
    }
}
