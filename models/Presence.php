<?php
class Presence {
	private $id, $presence_time, $name;

	public function __construct(string $stamp, $name) {
		$this->presence_time = $stamp;
		$this->name = $name;
	}

    public function getId() {
        return $this->id;
    }

	public function store() {
		$sql = "INSERT INTO presences (presence_time, name) VALUES (?, ?)";
        $values = array($this->presence_time, $this->name);

        $db = new DB();
        $db->execute($sql, $values);
        $this->id = $db->getLastId();
	}

	public static function getByName(string $name) : array {
		$sql = "SELECT * FROM presences WHERE name = ?";
        $values = array($name);

        return (new DB())->execute($sql, $values);
	}

	public static function getByTimestamp(string $timestamp) : array {
		$sql = "SELECT * FROM presences WHERE presence_time = ?";
		$values = array($timestamp);

		return (new DB())->execute($sql, $values);
	}
}
