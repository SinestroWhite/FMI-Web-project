<?php

/*
|--------------------------------------------------------------------------
| BigBlueButtonParser Save Error
|--------------------------------------------------------------------------
|
| This error is thrown when a file cannot be written on the disk.
|
*/

class IncompleteFormError extends CustomError {
    public function __construct() {
        parent::__construct("Please fill all the fields in the form.");
    }
}
