<?php

/*
|--------------------------------------------------------------------------
| Invalid File Structure Error
|--------------------------------------------------------------------------
|
| This error is thrown when the user attempts to upload a disallowed
| file structure.
|
*/

class InvalidFileStructureError extends CustomError {
    public function __construct(int $lineNumber, string $row) {
        parent::__construct("There is a problem on line: " . $lineNumber . ":   \"" . $row . "\".");
    }
}
