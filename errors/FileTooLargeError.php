<?php

/*
|--------------------------------------------------------------------------
| File Too Large Error
|--------------------------------------------------------------------------
|
| This error is thrown when the user attempts to upload a file larger than 0.5MB.
|
*/

class FileTooLargeError extends CustomError {
    public function __construct() {
        parent::__construct("The file is too large. The maximum size is 0.5MB");
    }
}
