<?php

class UserNotFoundError extends Error {
    public function __construct() {
        parent::__construct("User not found.");
    }
}