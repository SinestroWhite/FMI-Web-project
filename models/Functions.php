<?php
class Functions {


	public static function prepareMultipleInsertSQL(string $table, string $columns, int $count) : string {

		return $sql = "INSERT IGNORE INTO $table ($columns) VALUES" . $this->getQuestionMarks();
	}


	private function getQuestionMarks() : string{
		for($i = 0; $i < $count; $i++) {
			$questionMarks[] = "(" . $this->getPlaceHolder($columns) . ")";
		}

		return implode(", ", $questionMarks);
	}

	private function getPlaceHolder(string $columns) : string {

		$columnArr = explode(", ", $columns);

		for($columnArr as $val) {
			$questionMarks[] = "?";
		}

		return implode(",", $questionMarks);
	}

	

}
