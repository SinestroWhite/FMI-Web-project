<?php

/*
|--------------------------------------------------------------------------
| CSRF Token Error
|--------------------------------------------------------------------------
|
| This error is thrown when the user does not provide the correct CSRF
| token.
|
*/

class CSRFTokenError extends CustomError {
    public function __construct() {
        parent::__construct("The CSRF token does not match.");
    }
}
