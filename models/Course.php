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
        $connection = (new DB())->getConnection();
        $sql = "INSERT INTO courses (name, year, teacher_id) VALUES (?, ?, ?)";

        $stmt = $connection->prepare($sql);
        $result = $stmt->execute([$this->name, $this->year, $this->teacher_id]);

        if (!$result) {
            throw new DatabaseQueryError();
        }
    }

    public static function delete($id) {
        $connection = (new DB())->getConnection();
        $sql = "DELETE FROM courses WHERE id = ?";

        $stmt = $connection->prepare($sql);
        $result = $stmt->execute([$id]);

        if (!$result) {
            throw new DatabaseQueryError();
        }
    }

    public static function getAll($teacher_id): array {
        $connection = (new DB())->getConnection();
        $sql = "SELECT * FROM courses WHERE teacher_id = ?";

        $stmt = $connection->prepare($sql);
        $result = $stmt->execute([$teacher_id]);

        if (!$result) {
            throw new DatabaseQueryError();
        }

        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }
}
