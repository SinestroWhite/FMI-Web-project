<?php

class PlanCSVParser {
    public static function fileValidation(array $file): string {
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);

        if ($ext != "csv") {
            throw new InvalidFileFormatError();
        }

        if ($file["size"] > 500000) {
            throw new FileTooLargeError();
        }

        return file_get_contents($file["tmp_name"]);
    }

    private static function getData(string $file_data): Array {
        $rows = explode("\n", $file_data);

        $result = [];
        for ($i = 0; $i < count($rows); ++$i) {
            if (!empty($rows[$i])) {
                $temp_row = explode("\t", $rows[$i]);

                foreach ($temp_row as $col) {
                    if ($col == "") {
                        throw new InvalidFileStructureError($i + 1, $rows[$i]);
                    }
                }

                $result[] =  [
                    "faculty_number" => $temp_row[2],
                    "name" => $temp_row[4],
                    "topic" => $temp_row[6],
                    "start" => $temp_row[1],
                    "end" => $temp_row[1],
                ];
                // TODO: Fix end over a break
                if ($i > 0) {
                    $result[$i-1]['end'] = $result[$i]['start'];
                }
            }
        }

        $result[count($rows) - 1]['end'] = "11:00";

        return $result;
    }

    private static function getRealData(string $file_data) : Array {
        $rows = explode("\n", $file_data);

        $result = [];
        for ($i = 0; $i < count($rows); ++$i) {
            if (!empty($rows[$i])) {
                if (str_contains($rows[$i], "Почивка")) {
                    continue;
                }

                $temp_row = explode("\t", $rows[$i]);

                if (count($temp_row) != 8) {
                    throw new InvalidFileStructureError($i + 1, $rows[$i]);
                }

                foreach ($temp_row as $col) {
                    if ($col == "") {
                        throw new InvalidFileStructureError($i + 1, $rows[$i]);
                    }
                }

                $result[] =  [
                    "faculty_number" => $temp_row[3],
                    "name" => $temp_row[5],
                    "topic" => $temp_row[7],
                    "start" => $temp_row[1],
                    "end" => $temp_row[2],
                ];
            }
        }

        return $result;

    }

    public static function processPlan(string $plan, string $date) {
        $result = PlanCSVParser::getData($plan);

        $firstId = Student::StoreList($result);

        for ($i = 0; $i < count($result); ++$i) {
            $result[$i]['id'] = $firstId + $i;
        }

        $courseID = $_ENV['URL_PARAMS']['id'];
        $firstIdSCP = StudentCoursePivot::storeList($result, $courseID);

        for($i = 0; $i < count($result); ++$i) {
            $result[$i]['id'] = $firstIdSCP + $i;
        }

        $firstIdPaper = Paper::StoreList($result);
        TimeTable::storeList($result, $date, $firstIdPaper);

    }

    public static function processReal(string $real, string $date) {
        $result = PlanCSVParser::getRealData($real);

        $studentNames = [];
        $facultyNumbers = [];
        foreach ($result as $student) {
            $studentNames[] = $student['name'];
            $facultyNumbers[] = $student['faculty_number'];
        }

        $sql ='
            SELECT P.name AS topic, DATA.name, DATA.faculty_number, P.id AS paper_id
            FROM papers AS P
                JOIN (
                    SELECT SCP.id, S.name, S.faculty_number
                    FROM students_courses_pivot AS SCP
                        JOIN (
                            SELECT id, name, faculty_number
                            FROM students
                            WHERE name IN ' . DB::getQuestionLine(count($studentNames)) . '
                              AND faculty_number IN ' . DB::getQuestionLine(count($facultyNumbers)) . '
                        ) AS S ON SCP.student_id = S.id
                    WHERE SCP.course_id = (?)
            ) AS DATA ON P.student_course_pivot_id = DATA.id
        ';

        $values = [];
        foreach ($result as $student) {
            $values[] = $student['name'];
        }
        foreach ($result as $student) {
            $values[] = $student['faculty_number'];
        }
        $values[] = $_ENV['URL_PARAMS']['id'];

        $data = (new DB())->execute($sql, $values);

        $sql =<<<EOF
            UPDATE time_tables
            SET from_time_real = (?), to_time_real = (?)
            WHERE paper_id = (?)
        EOF;

        $values = [];

        function getPaperID($student, $data): string {
            foreach ($data as $datum) {
                if ($student['name'] == $datum['name'] &&
                    $student['faculty_number'] == $datum['faculty_number'] &&
                    $student['topic'] == $datum['topic']) {
                    return  $datum['paper_id'];
                }

            }

            return "";
        }

        foreach ($result as $student) {
            $paper_id = getPaperID($student, $data);

            $values[] = [
                $date . " " . $student['start'],
                $date . " " . $student['end'],
                $paper_id
            ];
        }

        (new DB())->multipleExecute($sql, $values);
    }
}
