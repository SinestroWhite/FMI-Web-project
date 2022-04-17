<?php

/*
|--------------------------------------------------------------------------
| File Open Error
|--------------------------------------------------------------------------
|
| This error is thrown when a file cannot be opened from the disk.
|
*/

class FileOpenError extends CustomError {
    public function __construct() {
        parent::__construct("File cannot be opened.");
    }
}
