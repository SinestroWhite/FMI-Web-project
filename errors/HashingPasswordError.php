<?php

class HashingPasswordError extends Error {
    public function __construct() {
        parent::__construct("The hashing has failed. Please, try again later.");
    }
}