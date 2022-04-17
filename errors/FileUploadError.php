<?php

/*
|--------------------------------------------------------------------------
| File Upload Error
|--------------------------------------------------------------------------
|
| This error is thrown when an uploaded file cannot be written on the disk.
|
*/

class FileUploadError extends Error {
    public function __construct() {
        parent::__construct("There was a technical problem and the file could not be saved.");
    }
}
