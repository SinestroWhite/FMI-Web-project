<html>
<head>
    <title>Dashboard</title>
</head>
<body>
<section class="data-section">
    <div id="courses">
        <h1>Курсове</h1>
        <ul>
            <?php
            $teacher_id = $_SESSION['id'];
            $courses = Course::getAll($teacher_id);
            foreach ($courses as $course) {
                echo "<li><a href=\"#\">" . $course["name"] . ", " . $course["year"] . "</a></li>";

            }
            ?>
        </ul>
    </div>
</section>

<a href="logout">Logout</a>

</body>
</html>

<?php

?>
