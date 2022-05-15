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

	public static function storeList(array $result) {
        $students = [];
        foreach($result as $student) {
            $students[] = $student['faculty_number'];
            $students[] = $student['name'];
        }
		$lenght = count($result);

		$sql = DB::prepareMultipleInsertSQL("students", "faculty_number, name", $lenght);

        $db = new DB();
		$db->execute($sql, $students);
        return $db->getLastId();
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
