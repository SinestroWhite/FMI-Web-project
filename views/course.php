<?php
    $courseID =$_ENV['URL_PARAMS']['id'];
    $data = Course::getById($courseID);
    $timeTableData = TimeTable::getAllByCourseId($courseID);

    $sql = <<<EOF
        SELECT CAST(MIN(T.from_time_planned) AS TIME) AS start_time,
               CAST(MAX(T.to_time_planned) AS TIME) AS end_time,
               CAST(T.from_time_planned AS DATE) AS date
        FROM students_courses_pivot AS SCP
            JOIN papers P on SCP.id = P.student_course_pivot_id
            JOIN time_tables T on P.id = T.paper_id
        WHERE course_id = (?)
        GROUP BY CAST(T.from_time_planned AS DATE);
    EOF;

    $timeRes = (new DB())->execute($sql, [$courseID]);
    var_dump($timeRes);
    function hoursToMinutes($timeRes): array {
        $result = [];
        foreach ($timeRes as $time) {
            $timeFirst = $time['start_time'];
            $timeSecond = $time['end_time'];
            $date = $time['date'];

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

    $times = hoursToMinutes($timeRes);
    var_dump($times);
?>

<html>
<head>
    <title><?= $data['name'] ?> - <?= $data['year'] ?></title>

    <style>
        table, tr, td {
            border: solid 1px black;
            border-collapse: collapse;
        }

        tr, td {
            padding: 3px 2px;
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
        <table>
            <thead>
                <tr>
                    <td>Име</td>
                    <td>ФН</td>
                    <td>Тема</td>
                    <td>Планирано начало</td>
<!--                    <td>Планиран край</td>-->
<!--                    <td>Реално начало</td>-->
<!--                    <td>Реален край</td>-->
<!--                    --><?php //foreach () ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timeTableData as $student) { ?>
                    <tr>
                        <td><?= $student['name'] ?></td>
                        <td><?= $student['faculty_number'] ?></td>
                        <td><?= $student['topic'] ?></td>
                        <td><?= $student['from_time_planned'] ?></td>
<!--                        <td>--><?//= $student['to_time_planned'] ?><!--</td>-->
<!--                        <td>--><?//= $student['from_time_real'] ?><!--</td>-->
<!--                        <td>--><?//= $student['to_time_real'] ?><!--</td>-->
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>

<a href="/logout">Logout</a>

</body>
</html>

<?php

?>
