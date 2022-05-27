
<section class="container data-section">
    <div id="courses">
        <h1>
            Курсове
            <a class="add-button button is-link icon-button" href="/add-course"><i class="fa-solid fa-plus"></i></a>
        </h1>
        <!-- TODO: Add URL protection so that one user cannot access the courses of another -->
        <?php
            $teacher_id = $_SESSION['id'];
            $courses = Course::getAll($teacher_id);

            if (count($courses) == 0) {
                ?>
                <p class="text-center">Няма създадени курсове, използвайте бутона „+“, за да добавите първия.</p>
                <?php
            }
        ?>
        <ul>
            <?php
                foreach ($courses as $course) {
                    echo "<li><a href=\"course/" . $course['id'] . "\">" . $course["name"] . ", " . $course["year"] . "</a></li>";
                }
            ?>
        </ul>
    </div>
</section>



