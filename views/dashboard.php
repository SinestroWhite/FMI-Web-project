
<section class="container data-section">
    <div id="courses">
        <h1>Курсове</h1>
        <!-- TODO: Add URL protection so that one user cannot access the courses of another -->
        <a href="/add-course">Създаване на нов курс</a>
        <ul>
            <?php
            $teacher_id = $_SESSION['id'];
            $courses = Course::getAll($teacher_id);
            foreach ($courses as $course) {
                echo "<li><a href=\"course/" . $course['id'] . "\">" . $course["name"] . ", " . $course["year"] . "</a></li>";
            }
            ?>
        </ul>
    </div>
    <a href="/logout">Logout</a>
</section>



