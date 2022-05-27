<section class="container data-section">
    <h2>Създаване на нов курс</h2>
    <form action="add-course" method="post">
        <label for="name">Name</label>
        <input class="input is-link" id="name" type="text" name="name"/>
        <label for="year">Year</label>
        <input class="input is-link" id="year" type="number" min="1990" max="2100" name="year"/>

        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
        <input class="button is-link" type="submit" name="add-course" value="Submit"/>
    </form>
</section>


<?php
if (isset($_POST['add-course'])) {
    $name = $_POST['name'];
    $year = $_POST['year'];

    $course = new Course($name, $year, $_SESSION['id']);
    $course->store();
    header('Location: /dashboard');
}
?>
