<?php

class Course {
    private $name, $year, $teacher_id;

    public function __construct($name, $year, $teacher_id) {
        $this->name = $name;
        $this->year = $year;
        $this->teacher_id = $teacher_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getYear() {
        return $this->year;
    }

    public function getTeacherId() {
        return $this->teacher_id;
    }

    public function store() {
        $sql = "INSERT INTO courses (name, year, teacher_id) VALUES (?, ?, ?)";
        $values = array($this->name, $this->year, $this->teacher_id);

        (new DB())->execute($sql, $values);
    }

    public static function delete($id) {
        $sql = "DELETE FROM courses WHERE id = ?";
        $values = array($id);

        (new DB())->execute($sql, $values);
    }

    public static function getAll($teacher_id): array {
        $sql = "SELECT * FROM courses WHERE teacher_id = ?";
        $values = array($teacher_id);

        return (new DB())->execute($sql, $values);
    }

    public static function getById($id): array {
        $sql = "SELECT * FROM courses WHERE id = ?";
        $values = array($id);

        return (new DB())->execute($sql, $values)[0];
    }

    public function hasDuplicate(): bool {
        return DB::hasDuplicate("SELECT * FROM courses WHERE name = (?) AND year = (?)", [$this->name, $this->year]);
    }

}
