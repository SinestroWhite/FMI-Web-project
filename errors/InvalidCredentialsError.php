<?php

class InvalidCredentialsError extends Error {
    public function __construct() {
        parent::__construct("Invalid Credentials.");
    }
}