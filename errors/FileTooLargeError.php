<?php
class FileTooLargeError extends Error {
    public function __construct() {
        parent::__construct("The file is too large. The maximum size is 0.5 MB");
    }
}
