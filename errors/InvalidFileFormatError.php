<?php

/*
|--------------------------------------------------------------------------
| Invalid File Format Error
|--------------------------------------------------------------------------
|
| This error is thrown when the user attempts to upload a disallowed
| file format.
|
*/

class InvalidFileFormatError extends Error {
    public function __construct() {
        parent::__construct("The file format is invalid.");
    }
}
