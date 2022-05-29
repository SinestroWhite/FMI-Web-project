<?php

/*
|--------------------------------------------------------------------------
| Duplicate Item Error
|--------------------------------------------------------------------------
|
| This error is thrown when a user tries to insert a duplicate item
|
*/

class DuplicateItemError extends CustomError {
    public function __construct() {
        parent::__construct("Не е позволено да съхранявате дублиращи се данни.");
    }
}
