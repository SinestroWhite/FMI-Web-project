<?php
class File {

	private $regex['time-stamp']   = "/([1-9]|1[0-2])\/([1-9]|1[0-9]|2[0-9]|3[0|1])\/(\d{4}):([0-9]|1[0-2]):([0-5]?[0-9]):([0-5]?[0-9]) (AM|PM)/";
	private $regex['student-list'] = "/Sorted by first name:\r\n(([^\r]|\r)*)\n  \r\n\r\nSorted by last name:/";

	public static function fileValidation(array $file) : string {
		$ext = pathinfo($file["tmp_name"], PATHINFO_EXTENSION);
	    if ($ext != "txt") {
	         throw new InvalidFileFormatError();
	    }


	    if ($file["size"] > 500000) {
	        throw new FileTooLargeError();
	    }

	    return file_get_contents($file["tmp_name"]);
	}

	public static function getTimestamp(string $fileContent) : string {
		$match = $this->find($fileContent, $this->regex['time-stamp']);
		
		return implode(":",$timestampMatch);
	}

	public static function getStudentList(string $fileContent) : array {
		$match = $this->find($fileContent, $this->regex['student-list']);

		return explode("\n", $match[1][0]);
	}

	private function find(string $fileContent, string $pattern) {
		$matches = [];
    	preg_match_all($pattern, $fileContent, $matches);

    	return $matches;
	}
}
