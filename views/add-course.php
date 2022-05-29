<section class="container data-section">
    <h2>Създаване на нов курс</h2>
    <form action="add-course" method="post">
        <label for="name">Име</label>
        <input class="input is-link" id="name" type="text" name="name" value="<?= $_POST['name'] ?>"/>
        <label for="year">Година</label>
        <input class="input is-link" id="year" type="number" min="1990" max="2100" name="year" value="<?= $_POST['year'] ?>"/>

        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
        <input class="button is-link" type="submit" name="add-course" value="Създаване"/>
    </form>
</section>


<?php
if (isset($_POST['add-course'])) {
    if (empty($_POST['name']) || empty($_POST['year'])) {
        throw new IncompleteFormError();
    }

    $name = $_POST['name'];
    $year = $_POST['year'];

    $course = new Course($name, $year, $_SESSION['id']);

    if ($course->hasDuplicate()) {
        throw new DuplicateItemError();
    }

    $course->store();
    header('Location: /dashboard');
}
?>
