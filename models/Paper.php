<?php

class Paper
{
    private $id, $name, $student_id, $is_presented;

    public function __construct($id, $name, $student_id, $is_presented) {
        $this->id = $id;
        $this->name = $name;
        $this->student_id = $student_id;
        $this->is_presented = $is_presented;
    }

    public function store() {
        $sql = "INSERT INTO papers (name, student_id, is_presented) VALUES (?, ?, ?)";
        $values = array($this->name, $this->student_id, $this->is_presented);

        (new DB())->execute($sql, $values);
    }

    public static function getById($id) {
        $sql = "SELECT FROM papres (name, student_id, is_presented) WHERE id = ?";
        $values = array($id);

        return (new DB())->select($sql, $values);
    }


}
