<?php
$courseID = Router::$ROUTE['URL_PARAMS']['id'];
$data = Course::getById($courseID);
$timeTableData = TimeTable::getAllByCourseId($courseID);

$data1 = Presence::getPresencesByCourseID($courseID);

$result = [];
foreach ($data1 as $element) {
    $result[$element['date']] = TimeTable::mapHours($element);
}

$date_times = TimeTable::getPlannedTimesByCourseID($courseID);
?>

<section class="mini-container data-section">
    <div id="courses">
        <h1>
            <a class="icon-back is-link" href="/dashboard"><i class="fa-solid fa-chevron-left"></i></a>
            <?= $data['name'] ?> - <?= $data['year'] ?>
        </h1>

        <a class="button is-link" href="/course/<?= Router::$ROUTE['URL_PARAMS']['id'] ?>/import-plan">Предварителен график</a>
        <?php if (count($timeTableData) != 0) { ?>
            <a class="button is-link" href="/course/<?= Router::$ROUTE['URL_PARAMS']['id'] ?>/import-real">Реален график</a>
            <a class="button is-link" href="/course/<?= Router::$ROUTE['URL_PARAMS']['id'] ?>/import-bbb">Присъствен списък от BBB</a>
        <?php } ?>
    </div>
</section>
<?php if (count($timeTableData) != 0) { ?>
<div class="table">
    <table>
        <thead>
        <tr>
            <td class="header" rowspan="2">Име</td>
            <td class="header1" rowspan="2">ФН</td>
            <td class="header2" rowspan="2">Тема</td>
            <?php foreach ($date_times as $i => $date_time) {
                $start_time = $date_time['start_time'];
                $end_time = $date_time['end_time'];
                $cellCount = TimeTable::hoursToMinutes($start_time, $end_time);
                ?>
                <td class="time <?php if ($date_time != end($date_times)) {
                    echo 'end';
                } ?>" colspan="<?= $cellCount ?>"><?= $date_time['date'] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <?php
            foreach ($date_times as $i => $date_time) {
                $start_time = $date_time['start_time'];
                $end_time = $date_time['end_time'];
                $cellCount = TimeTable::hoursToMinutes($start_time, $end_time);

                for ($i = 0; $i < $cellCount; $i += 15) {
                    ?>
                    <td class="time <?php if ($i + $cellCount % 15 == $cellCount) {
                        echo 'end';
                    } ?>" colspan="<?= $i + $cellCount % 15 == $cellCount ? $cellCount % 15 : 15 ?>">
                        <?= TimeTable::addTime($start_time, $i) . ' - ' . (($i + $cellCount % 15 == $cellCount) ?
                            substr($end_time, 0, -3) :
                            TimeTable::addTime($start_time, $i + 15)) ?>
                    </td>
                    <?php
                }
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($timeTableData as $student) { ?>
            <tr>
                <td class="header" title="<?= $student['name'] ?>">
                    <div class="hide-long-text">
                        <span>
                            <?= $student['name'] ?>
                        </span>
                    </div>
                </td>
                <td class="header1"><?= $student['faculty_number'] ?></td>
                <td class="header2" title="<?= $student['topic'] ?>">
                    <div class="hide-long-text">
                        <span>
                            <?= $student['topic'] ?>
                        </span>
                    </div>
                </td>
                <?php foreach ($date_times as $i => $date_time) {
                    $start_time = $date_time['start_time'];
                    $end_time = $date_time['end_time'];
                    $cellCount = TimeTable::hoursToMinutes($start_time, $end_time);

                    for ($j = 0; $j < $cellCount; ++$j) {
                        $currTime = TimeTable::addTime($start_time, $j);
                        $presences = $result[$date_time['date']];

                        ?>
                        <td class="<?= TimeTable::isPlanned($currTime, $student['from_time_planned'], true, $date_time['date']) ?>
                                       <?= TimeTable::isPlanned($currTime, $student['to_time_planned'], false, $date_time['date']) ?>
                                       <?= TimeTable::isMid($currTime, $student['from_time_planned'], $student['to_time_planned'], $date_time['date'], 'mid') ?>
                                       <?= TimeTable::isMid($currTime, $student['from_time_real'], $student['to_time_real'], $date_time['date'], 'green') ?>
                                       <?= TimeTable::determinePresence($currTime, $presences, $student['student_id']) ?>
                                       <?= TimeTable::isLast($currTime, $end_time, $date_time, $date_times) ?>"
                            title="<?= $currTime ?>">
                            <div class="presence"></div>
                        </td>
                        <?php
                    }
                } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <section class="mini-container">
        <p class="text-center">Все още няма информация за студентите в курса. Моля, първо качете предварителния график
            за представянето.</p>
    </section>
<?php } ?>


