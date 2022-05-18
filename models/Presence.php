<?php
class Presence {
	private $id, $presence_time, $student_course_pivot;

	public function __construct(string $stamp, $student_course_pivot) {
		$this->presence_time = $stamp;
		$this->student_course_pivot = $student_course_pivot;
	}

    public function getId() {
        return $this->id;
    }

	public function store() {
		$sql = "INSERT INTO presences (presence_time, student_course_pivot) VALUES (?, ?)";
        $values = array($this->presence_time, $this->student_course_pivot);

        $db = new DB();
        $db->execute($sql, $values);
        $this->id = $db->getLastId();
	}

	/*public static function getByName(string $name) : array {
		$sql = "SELECT * FROM presences WHERE name = ?";
        $values = array($name);

        return (new DB())->execute($sql, $values);
	}*/

	public static function getByTimestamp(string $timestamp) : array {
		$sql = "SELECT * FROM presences WHERE presence_time = ?";
		$values = array($timestamp);

		return (new DB())->execute($sql, $values);
	}

    public static function storeList(string $timestamp, array $student_course_pivot_ids) {
        $result = [];
        foreach ($student_course_pivot_ids as $id) {
            $result[] = $timestamp;
            $result[] = $id['id'];
        }
        $sql = DB::prepareMultipleInsertSQL("presences", "presence_time, student_course_pivot_id", count($student_course_pivot_ids));

        $db = new DB();
        $db->execute($sql, $result);

        return $db->getLastId();
    }
}
