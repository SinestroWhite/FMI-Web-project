<?php

/*
|--------------------------------------------------------------------------
| User Not Found Error
|--------------------------------------------------------------------------
|
| This error is thrown when a user in the database cannot be found.
|
*/

class UserNotFoundError extends Error {
    public function __construct() {
        parent::__construct("User not found.");
    }
}
