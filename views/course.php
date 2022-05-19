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

            $result[] = [
                $minutesSecond - $minutesFirst,
                $date
            ];
        }

        return $result;
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

    $sql_presence = <<<EOF
        SELECT SCP.student_id, P.presence_time
        FROM students_courses_pivot AS SCP
            JOIN presences P on SCP.id = P.student_course_pivot_id
        WHERE course_id = (?)
    EOF;
var_dump((new DB())->execute($sql_presence, [$courseID]));

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
            width: 9px;
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
                    <?php for ($i = 0; $i <= $cellCount; ++$i) { ?>
                        <td class="time"><?= addTime($start_time, $i) ?></td>
                    <?php } ?>
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
                        <?php for ($i = 0; $i < $cellCount; ++$i) { ?>
                            <td title="<?= addTime($start_time, $i) ?>">
<!--                                <div class="presence"></div>-->
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
