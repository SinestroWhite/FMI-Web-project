<html>
<head>
    <title>Dashboard | Add Course</title>
</head>
<body>
<section class="data-section">
    <div id="courses">
        <h1>Създаване на нов курс</h1>

        <form action="add-course" method="post">
            <label for="name">Name</label>
            <input id="name" type="text" name="name"/>
            <label for="year">Year</label>
            <input id="year" type="number" min="1990" max="2100" name="year"/>

            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
            <input type="submit" name="add-course" value="Submit"/>
        </form>
    </div>
</section>

<a href="/logout">Logout</a>

</body>
</html>

<?php
if (isset($_POST['add-course'])) {
    $name = $_POST['name'];
    $year = $_POST['year'];

    $course = new Course($name, $year, $_SESSION['id']);
    $course->store();
    header('Location: dashboard');
}
?>
