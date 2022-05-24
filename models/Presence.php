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

    public static function getPresencesByCourseID($courseID): array {
        $sql =<<<EOF
            SELECT CAST(P.presence_time AS DATE) AS date,
                   JSON_ARRAYAGG(CAST(P.presence_time AS TIME)) AS times,
                   JSON_ARRAYAGG(SCP.student_id) AS student_ids
            FROM presences AS P
                JOIN (
                        SELECT id, student_id
                        FROM students_courses_pivot
                        WHERE course_id = (?)
                    ) AS SCP on SCP.id = P.student_course_pivot_id
            GROUP BY CAST(P.presence_time AS DATE);
        EOF;

        return (new DB())->execute($sql, [$courseID]);
    }
}
