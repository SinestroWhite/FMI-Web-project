<?php

/*
|--------------------------------------------------------------------------
| Invalid Password Error
|--------------------------------------------------------------------------
|
| This error is thrown when the user submits a password that does not
| follow the requirements.
|
*/

class InvalidPasswordError extends Error {
    public function __construct() {
        parent::__construct("Password is not at least 6 symbols long or
         does not include: an upper case letter, a lower case letter, a
         number, a special symbol.");
    }
}
