<?php
class Student {
	private $name, $fn;

	public function __construct(string $name, string $fn) {
		$this->name = $name;
        $this->fn = $fn;

	}

	public function store() {
		$sql = "INSERT INTO students (name) VALUES (?)";
        $values = array($this->name);

        (new DB())->execute($sql, $values);
	}

	public static function storeList(array $list) {
		$lenght = count($list);
		$sql = DB::prepareMultipleInsertSQL("students", "name", $lenght);

		(new DB())->execute($sql, $list);
	}

	public static function getByName(string $name) : array {
		$sql = "SELECT * FROM students WHERE name = ?";
        $values = array($name);

        $data = (new DB())->execute($sql, $values);

        if (count($data) != 1) {
            throw new UserNotFoundError();
        }

        return $data[0];
	}
}
