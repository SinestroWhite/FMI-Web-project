<?php
class Student {
	private $name;

	public function __construct(string $name) {
		$this->name = $name;
	}

	public function store() {
		$sql = "INSERT INTO students (name) VALUES (?)";
        $values = array($this->name);

        (new DB())->store($sql, $values);
	}

	public static function storeList(array $list) {
		$lenght = count($list);
		$sql = Functions::prepareMultipleInsertSQL("students", "name", $lenght);

		(new DB())->store($sql, $values);
	}


	public static function getByName(string $name) : array {
		$sql = "SELECT * FROM students WHERE name = ?";
        $values = array($name);

        return (new DB())->select($sql, $values);
	}


}