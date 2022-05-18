<?php
class Student {
	private $facultyNumber, $name;

	public function __construct(string $facultyNumber, string $name) {
        $this->facultyNumber = $facultyNumber;
        $this->name = $name;
	}

	public function store() {
		$sql = "INSERT INTO students (faculty_number, name) VALUES (?, ?)";
        $values = array($this->facultyNumber, $this->name);

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

    public static function getByNames(array $students): array {
        $sql = "SELECT * FROM students WHERE name IN " . DB::getQuestionLine(count($students));
        return (new DB())->execute($sql, $students);
    }
}
