<?php
class Presence {
	private $stamp, $name;

	public function __construct(string $stamp, $name) {
		$this->stamp = $stamp;
		$this->name = $name;
	}

	public function store() {
		$sql = "INSERT INTO presence (stamp, name) VALUES (?, ?)";
        $values = array($this->stamp, $this->name);

        (new DB())->store($sql, $values);
	}

	public static function getByName(string $name) : array {
		$sql = "SELECT * FROM presence WHERE name = ?";
        $values = array($name);

        return (new DB())->select($sql, $values);
	}

	public static function getByTimestamp(string $timestamp) : array {
		$sql = "SELECT * FROM presence WHERE stamp = ?";
		$values = array($timestamp);

		return (new DB())->select($sql, $values);
	}
}