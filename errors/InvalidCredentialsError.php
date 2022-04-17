<?php

/*
|--------------------------------------------------------------------------
| Invalid Credentials Error
|--------------------------------------------------------------------------
|
| This error is thrown when the user attempts to login with invalid
| credentials.
|
*/

class InvalidCredentialsError extends Error {
    public function __construct() {
        parent::__construct("Invalid Credentials.");
    }
}
