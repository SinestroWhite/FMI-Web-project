<?php

/*
|--------------------------------------------------------------------------
| Database Query Error
|--------------------------------------------------------------------------
|
| This error is thrown when the database cannot execute an SQL request.
|
*/

class DatabaseQueryError extends CustomError {
    public function __construct() {
        parent::__construct("There was a technical problem and your request was not fulfilled.");
    }
}
