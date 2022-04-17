<?php

/*
|--------------------------------------------------------------------------
| Hashing Password Error
|--------------------------------------------------------------------------
|
| This error is thrown when the hashing algorithm fails to confirm that the
| newly hashed password matches the original one.
|
*/

class HashingPasswordError extends Error {
    public function __construct() {
        parent::__construct("The hashing has failed. Please, try again later.");
    }
}
