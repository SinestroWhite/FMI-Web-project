<?php

/*
|--------------------------------------------------------------------------
| Password Mismatch Error
|--------------------------------------------------------------------------
|
| This error is thrown when the user did not confirm their password
| correctly.
|
*/

class PasswordMismatchError extends Error {
    public function __construct() {
        parent::__construct("The passwords do not match.");
    }
}
