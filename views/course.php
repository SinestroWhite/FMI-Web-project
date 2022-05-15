<?php
    $data = Course::getById($_ENV['URL_PARAMS']['id']);
?>

<html>
<head>
    <title>Dashboard</title>
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
                    <td>Планиран край</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timeTableData as $student) { ?>
                    <tr>
                        <td><?= $student['name'] ?></td>
                        <td><?= $student['faculty_number'] ?></td>
                        <td><?= $student['topic'] ?></td>
                        <td><?= $student['from_time'] ?></td>
                        <td><?= $student['to_time'] ?></td>
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
