<?php
    $courseID =$_ENV['URL_PARAMS']['id'];
    $data = Course::getById($courseID);
    $timeTableData = TimeTable::getAllByCourseId($courseID);

    $sql = <<<EOF
        SELECT MIN(CAST(T.from_time_planned AS TIME)) AS start_time,
               MAX(CAST(T.to_time_planned AS TIME)) AS end_time
        FROM students_courses_pivot AS SCP
            JOIN papers P on SCP.id = P.student_course_pivot_id
            JOIN time_tables T on P.id = T.paper_id
        WHERE course_id = (?)
    EOF;


    $timeRes = (new DB())->execute($sql, [$courseID]);
    $start_time = $timeRes[0]['start_time'];
    $end_time = $timeRes[0]['end_time'];

    function hoursToMinutes($timeFirst, $timeSecond): int {
        $arrFirst  = explode(":", $timeFirst);
        $arrSecond = explode(":", $timeSecond);

        $minutesFirst  = intval($arrFirst[0]) * 60 + intval($arrFirst[1]);
        $minutesSecond = intval($arrSecond[0]) * 60 + intval($arrSecond[1]);

        return ($minutesSecond - $minutesFirst);
    }

      $cellCount = hoursToMinutes($start_time, $end_time);

    function addTime($start_time, $minutes) {
        $arrTime = explode(":", $start_time);
        $start_minutes = intval($arrTime[0]) * 60 + intval($arrTime[1]);
        $total_minutes = $start_minutes + $minutes;
        $res_hours = floor($total_minutes / 60);
        $res_minutes = ($total_minutes % 60);

        return sprintf('%02d:%02d', $res_hours, $res_minutes);
    }

//    $sql_presence = <<<EOF
//        SELECT SCP.student_id, P.presence_time
//        FROM students_courses_pivot AS SCP
//            JOIN presences P on SCP.id = P.student_course_pivot_id
//        WHERE course_id = (?)
//    EOF;
//var_dump((new DB())->execute($sql_presence, [$courseID]));




//    $sql =<<<EOF
//        SELECT CAST(from_time_planned AS DATE) AS date, JSON_ARRAYAGG(SCP.student_id) AS student_ids, JSON_ARRAYAGG(P2.presence_time) AS presencs
//        FROM time_tables AS TT
//            JOIN papers P on TT.paper_id = P.id
//            JOIN presences P2 on P.student_course_pivot_id = P2.student_course_pivot_id
//            JOIN students_courses_pivot AS SCP ON P.student_course_pivot_id = SCP.id
//        GROUP BY CAST(from_time_planned AS DATE);
//    EOF;

//    $sql =<<<EOF
//        SELECT P.presence_time, SCP.student_id
//        FROM presences AS P
//            JOIN students_courses_pivot SCP on P.student_course_pivot_id = SCP.id
//    EOF;

    $sql =<<<EOF
        SELECT CAST(P.presence_time AS DATE) AS date,
               JSON_ARRAYAGG(CAST(P.presence_time AS TIME)) AS times,
               JSON_ARRAYAGG(SCP.student_id) AS student_ids
        FROM presences AS P
            JOIN (
                    SELECT id, student_id
                    FROM students_courses_pivot
                    WHERE course_id = (?)
                ) AS SCP on SCP.id = P.student_course_pivot_id
        GROUP BY CAST(P.presence_time AS DATE);
    EOF;

    $data1 = (new DB())->execute($sql, [$courseID]);

    function mapHours($element): array {
        $result = [];
        $times = json_decode($element['times']);
        $students = json_decode($element['student_ids']);
        foreach ($times as $i => $time) {
            $time = substr($time,0,-3);
            $result[$time][] = $students[$i];
        }
        return $result;
    }

    $result = [];
    foreach ($data1 as $element) {
        $result[$element['date']] = mapHours($element);
    }
    var_dump($result);


?>

<html>
<head>
    <title><?= $data['name'] ?> - <?= $data['year'] ?></title>

    <style>
        .table {
            width: 90%;
            overflow-x: auto;
            margin: 10px 0;
        }

        table, tr, td {
            border: solid 1px black;
            border-collapse: collapse;
            white-space: nowrap;
        }

        tr, td {
            padding: 3px 2px;
        }

        .time {
            /*transform: rotate(300deg);*/
            font-size: 10pt;
            padding: 0 2px;
        }

        .header {
            left: 0;
            position: sticky;
            background-color: #f1f1f1;
            /*width: 300px;*/
        }

        .header1 {
            left: 180px;
            position: sticky;
            background-color: #d0d0d0;
            /*border: 1px solid black;*/
        }

        .header2 {
            left: 234px;
            position: sticky;
            background-color: #f1f1f1;
            /*border-right: 1px solid black;*/
        }

        .presence {
            width: 5px;
        }

        .green {
            background-color: mediumseagreen;
        }

        .red {
            background-color: indianred;
        }

        .border {
            border: 2px solid black;
        }
    </style>
</head>
<body>
<section class="data-section">
    <div id="courses">
        <h1><?= $data['name'] ?> - <?= $data['year'] ?></h1>
        <p><a href="/dashboard">Dashboard</a></p>
        <p><a href="/course/<?= $_ENV['URL_PARAMS']['id'] ?>/import-plan">Импортиране на предварителен график на защитити на реферати</a></p>
        <p><a href="/course/<?= $_ENV['URL_PARAMS']['id'] ?>/import-real">Импортиране на реален график на защити на реферати</a></p>
        <a href="/course/<?= $_ENV['URL_PARAMS']['id'] ?>/import-bbb">Импортиране на присъствен списък от BBB</a>
        <div class="table">
        <table>
            <thead>
                <tr>
                    <td class="header">Име</td>
                    <td class="header1">ФН</td>
                    <td class="header2">Тема</td>
<!--                    <td>Планирано начало</td>-->
<!--                    <td>Планиран край</td>-->
<!--                    <td>Реално начало</td>-->
<!--                    <td>Реален край</td>-->
<!--                    <td colspan="--><?//= $cellCount ?><!--">02.04.2022</td>-->
<!--                    --><?php //for ($i = 0; $i <= $cellCount; ++$i) { ?>
<!--                        <td class="time">--><?//= addTime($start_time, $i) ?><!--</td>-->
<!--                    --><?php //} ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timeTableData as $student) { ?>
                    <tr>
                        <td class="header"><?= $student['name'] ?></td>
                        <td class="header1"><?= $student['faculty_number'] ?></td>
                        <td class="header2"><?= $student['topic'] ?></td>
<!--                        <td>--><?//= $student['from_time_planned'] ?><!--</td>-->
<!--                        <td>--><?//= $student['to_time_planned'] ?><!--</td>-->
<!--                        <td>--><?//= $student['from_time_real'] ?><!--</td>-->
<!--                        <td>--><?//= $student['to_time_real'] ?><!--</td>-->
                        <?php foreach ($result as $i => $item) {
                                for ($j = 0; $j < $cellCount; ++$j) {
                                    $currTime = addTime($start_time, $j);
                                    // $currTime in $result[$i] ?
                                    if (in_array($currTime, $item)) {
                                        if (in_array($student['id'], $item[$currTime])) {
                                            ?>
                                                <td class="green"></td>
                                            <?php
                                        } else {
                                            ?>
                                                <td class="red"></td>
                                            <?php
                                        }
                                    }
                                }
                            ?>
                            <td title="<?= $currTime = addTime($start_time, $i); ?>">
                                <div class="presence"></div>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
</section>

<a href="/logout">Logout</a>

</body>
</html>

<?php

?>
