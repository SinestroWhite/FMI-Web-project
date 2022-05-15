<?php
class StudentCoursePivot {
	private $studentID, $courseID;

	public static function storeList(array $students, int $courseID) {
		$sql = DB::prepareMultipleInsertSQL("students_courses_pivot", "student_id, course_id", count($students));

        $values = [];
		foreach($students as $student) {
			$values[] = $student['id'];
			$values[] = $courseID;
		}

        (new DB())->execute($sql, $values);
	}
}
