<?php

/*
|--------------------------------------------------------------------------
| Invalid BigBlueButtonParser Format Error
|--------------------------------------------------------------------------
|
| This error is thrown when the user attempts to upload a disallowed
| file format.
|
*/

class InvalidEmailError extends CustomError {
    public function __construct() {
        parent::__construct("Избраният имейл не е валиден.");
    }
}
