<?php
class Functions {
	public static function prepareMultipleInsertSQL(string $table, string $columns, int $count) : string {
		return $sql = "INSERT IGNORE INTO $table ($columns) VALUES " . Functions::getQuestionMarks($count, $columns);
	}

    public static function prepareMultipleData(array $values): array {
        $result = [];
        foreach ($values as $value) {
            $result[] = [$value];
        }
        return $result;
    }

	private static function getQuestionMarks(int $count, string $columns): string {
        if ($count <= 0) {
            throw new UnexpectedValueError();
        }

        $questionMarks = [];

		for($i = 0; $i < $count; $i++) {
			$questionMarks[] = "(" . Functions::getPlaceHolder($columns) . ")";
		}

		return implode(", ", $questionMarks);
	}

	private static function getPlaceHolder(string $columns) : string {
		$columnArr = explode(", ", $columns);
        $questionMarks = [];

		foreach ($columnArr as $val) {
			$questionMarks[] = "?";
		}

		return implode(",", $questionMarks);
	}
}
