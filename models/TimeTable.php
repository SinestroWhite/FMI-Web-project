<?php
/*
 * CREATE TABLE time_tables
(
    id        INT       NOT NULL AUTO_INCREMENT,
    paper_id  INT       NOT NULL,
    is_real   BOOLEAN   NOT NULL,
    from_time TIMESTAMP NOT NULL,
    to_time   TIMESTAMP NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (paper_id) REFERENCES papers (id)
);
 */

class TimeTable
{
    private $id, $paper_id, $from_time_planned, $to_time_planned, $from_time_real, $to_time_real;

    public function __construct($paper_id, $from_time_planned, $to_time_planned, $from_time_real, $to_time_real) {
        $this->paper_id   = $paper_id;
        $this->from_time_planned  = $from_time_planned;
        $this->to_time_planned    = $to_time_planned;
        $this->from_time_real     = $from_time_real;
        $this->to_time_real       = $to_time_real;
    }

    public function store() {
        $sql = "INSERT INTO time_tables (paper_id, from_time_planned, to_time_planned, from_time_real, to_time_real) VALUES (?, ?, ?, ?, ?)";
        $values = array($this->paper_id, $this->from_time_planned, $this->to_time_planned, $this->from_time_real, $this->to_time_real);

        (new DB())->execute($sql, $values);
    }

    public static function storeList(array $result, string $date, int $firstId) {
        $table = [];
        for ($i = 0; $i < count($result); ++$i) {
            $table[] = $firstId + $i;
            $table[] = $date . " " . $result[$i]['start'];
            $table[] = $date . " " . $result[$i]['end'];
        }

        $length = count($result);
        $sql = DB::prepareMultipleInsertSQL("time_tables", "paper_id, from_time_planned, to_time_planned", $length);

        (new DB())->execute($sql, $table);
    }

    public static function getAllByCourseId($id): array {
        // Ekstra SQL
        $sql = <<<EOF
            SELECT S.name, S.id AS student_id, S.faculty_number, P.name AS topic, T.from_time_planned, T.to_time_planned
            FROM students_courses_pivot AS SCP
                JOIN students S on SCP.student_id = S.id
                JOIN papers AS P ON P.student_course_pivot_id = SCP.id
                JOIN time_tables AS T on P.id = T.paper_id
            WHERE course_id = (?)
        EOF;
        $values = array($id);

        return (new DB())->execute($sql, $values);
    }
}
