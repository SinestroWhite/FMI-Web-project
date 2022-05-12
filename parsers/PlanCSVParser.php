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

    public static function processPlan(string $plan) {
        $result = PlanCSVParser::getData($plan);
        TimeTable::storeList($result);
    }
}
