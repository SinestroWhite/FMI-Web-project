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
    private $id, $paper_id, $is_real, $from_time, $to_time;

    public function __construct($paper_id, $is_real, $from_time, $to_time) {
        $this->paper_id   = $paper_id;
        $this->is_real    = $is_real;
        $this->from_time  = $from_time;
        $this->to_time    = $to_time;
    }

    public function store() {
        $sql = "INSERT INTO time_tables (paper_id, is_real, from_time, to_time) VALUES (?, ?, ?, ?)";
        $values = array($this->paper_id, $this->is_real, $this->from_time, $this->to_time);

        (new DB())->execute($sql, $values);
    }

    public static function storeList(array $list) {
        $length = count($list);
        $sql = DB::prepareMultipleInsertSQL("time_tables", "paper_id,is_real,from_time,to_time", $length);

        (new DB())->execute($sql, $list);
    }

}
