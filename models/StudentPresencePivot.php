<?php
class StudentPresencePivot {
	private $studentID, $presenceID;

	public static function storeList(array $students, int $presence_id) {
		$sql = DB::prepareMultipleInsertSQL("students_presence_pivot", "student_id, presence_id", count($students));

		foreach($students as $index=>$student) {
            // TODO: Optimize the number of sql requests
			$studentDB = Student::getByName($student);

			$values[] = $studentDB['id'];
			$values[] = $presence_id;
		}

		(new DB())->execute($sql, $values);
	}
}
