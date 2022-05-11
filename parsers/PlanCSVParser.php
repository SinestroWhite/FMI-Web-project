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
        $column_names = explode(",", $rows[0]);

        $result = [];
        for ($i = 1; $i < count($rows); ++$i) {
            if (!empty($rows[$i])) {
                $temp_row = explode(",", $rows[$i]);
                $result[] =  [
                    "name" => $temp_row[0],
                    "topic" => $temp_row[1],
                    "start" => $temp_row[2],
                    "end" => $temp_row[3],
                    "date" => $temp_row[4]
                ];
            }
        }

        return $result;
    }

    public static function processFile($file) {
        $file_content = PlanCSVParser::fileValidation($file);
        $result = PlanCSVParser::getData($file_content);
        var_dump($result);

        (new DB())->getConnection();
    }
}
