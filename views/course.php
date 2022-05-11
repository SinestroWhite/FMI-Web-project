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
        <a href="add-course">Създаване на нов курс</a>
        <h1><?= $data['name'] ?> - <?= $data['year'] ?></h1>

    </div>
</section>

<a href="logout">Logout</a>

</body>
</html>

<?php

?>
