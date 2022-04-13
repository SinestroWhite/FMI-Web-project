<?php

class PasswordMismatchError extends Error {
    public function __construct() {
        parent::__construct("The passwords do not match.");
    }
}