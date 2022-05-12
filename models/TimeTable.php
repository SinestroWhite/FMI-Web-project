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
    private $id, $paper_id, $from_time, $to_time, $date;

    public function __construct($paper_id, $official_from, $official_to, $actual_from, $actual_to) {
        $this->paper_id      = $paper_id;
        $this->official_from = $official_from;
        $this->official_to   = $official_to;
        $this->actual_from   = $actual_from;
        $this->actual_to     = $actual_to;
    }

    public function store() {
        $sql = "INSERT INTO time_tables (paper_id, official_from, official_to, actual_from, actual_to) VALUES (?, ?, ?, ?, ?)";
        $values = array($this->paper_id, $this->official_from, $this->official_to, $this->actual_from, $this->actual_to);

        (new DB())->execute($sql, $values);
    }

    public static function storeList(array $list) {
        $length = count($list);
        $sql = DB::prepareMultipleInsertSQL("time_tables", "paper_id, ", $length);

        (new DB())->execute($sql, $list);
    }

}
