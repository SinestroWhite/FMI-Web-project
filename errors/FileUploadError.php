<?php
class FileUploadError extends Error {
    public function __construct() {
        parent::__construct("The file could not be saved.");
    }
}
