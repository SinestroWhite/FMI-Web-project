<?php

class DatabaseQueryError extends Error {
    public function __construct() {
        parent::__construct("The database could not save your request.");
    }
}