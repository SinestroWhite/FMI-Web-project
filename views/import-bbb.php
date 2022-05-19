<?php
if (isset($_POST["import"])) {
    $fileContent = BigBlueButtonParser::fileValidation($_FILES['presence_list']);

    // TODO: fix timesamp 12-hour format to 24-hour format
    $stamp = BigBlueButtonParser::getTimestamp($fileContent);
    if ($_POST['confirm'] != "true" && count(Presence::getByTimestamp($stamp)) != 0) {
        ?>
        <script>
            alert('Списъкът вече е качен. Моля потвърдете, че искате да се качи отново.');
        </script>
        <?php
    } else {
        $students = BigBlueButtonParser::getStudentList($fileContent);
        $students = Student::getByNames($students);

        $student_course_pivots_ids = StudentCoursePivot::getIDs($students, $_ENV['URL_PARAMS']['id']);

        $presence = Presence::storeList($stamp, $student_course_pivots_ids);
        // TODO: students may be in the BBB text file but not in the students table
        header("Location: /course/" . $_ENV['URL_PARAMS']['id']);
    }
}
?>
<html>
<head>
    <title>Import Presence</title>
</head>
<body>
<section class="data-section">
    <h1>Импортиране на присъствен списък</h1>
    <form action="import-bbb" method="post" enctype="multipart/form-data">
        <input type="file" name="presence_list">
        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
        <input type="submit" value="Качване" name="import"/>
        <label>
            <input type="checkbox" name="confirm" value="true"/>
            Ако списъка вече е импортиран, искате ли да го качите отново?
        </label>
    </form>
</section>

<a href="/logout">Logout</a>


</body>
</html>


