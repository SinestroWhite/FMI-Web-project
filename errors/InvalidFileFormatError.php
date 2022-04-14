<?php
class InvalidFileFormatError extends Error {
    public function __construct() {
        parent::__construct("The file format is invalid.");
    }
}
