<?php
class StudentPresencePivot {
	private $studentID, $presenceID;


	public static function storeList(array $students, string $stamp) {
		$sql = Function::prepareMultipleInsertSQL("students_presence_pivot", "students_id, presence_id", count($students));

		foreach($students as $index=>$student) {
			$studentDB = Student::getByName($student);
			
			$values[$index][0] = $studentDB['id'];
			$values[$index][1] = $stamp;
		}

		(new DB())->store($sql, $values);
	}
}