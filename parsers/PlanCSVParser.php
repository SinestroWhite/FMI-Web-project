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

                $result[] =  [
                    "faculty_number" => $temp_row[2],
                    "name" => $temp_row[4],
                    "topic" => $temp_row[6],
                    "start" => $temp_row[1],
                    "end" => "",
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
        $result = PlanCSVParser::getData($real);

        $sql =<<<EOF
            SELECT id, name, faculty_number
            FROM students
            WHERE (name, faculty_number) IN (?)
        EOF;

        foreach ($result as $) {

       }

        # INSERT INTO time_tables (paper_id, from_time_real, to_time_real)
        # SELECT S.faculty_number, S.name, P.name AS topic, TT.id AS time_table_id
        # FROM papers AS P
        #         JOIN students_courses_pivot AS SCP ON SCP.id = P.student_course_pivot_id
        #         JOIN students S on SCP.student_id = S.id
        #         JOIN time_tables TT on P.id = TT.paper_id
        #     WHERE S.faculty_number IN () AND S.name IN (????) AND P.name IN (????)

        /*
            to update :
            get timetable id by paper id
            get paper id by $real['topic']

        */


    }
}
