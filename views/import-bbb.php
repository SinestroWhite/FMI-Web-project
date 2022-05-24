
<html>
<head>
    <title>Import Presence</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/import-bbb.css"/>
</head>
<body>
<section class="data-section">
    <h1>Импортиране на присъствен списък</h1>
    <p><a href="<?= '/course/' . $this->ROUTE['URL_PARAMS']['id'] ?>">Назад към курса</a></p>
    <?php
    if (isset($_POST["import"])) {
        $fileContent = BigBlueButtonParser::fileValidation($_FILES['presence_list']);

        // TODO: fix timesamp 12-hour format to 24-hour format
        $stamp = BigBlueButtonParser::getTimestamp($fileContent);
        if ($_POST['confirm'] != "true" && count(Presence::getByTimestamp($stamp)) != 0) {
            ?>
                <p class="red">Списъкът вече е качен. Моля потвърдете, че искате да се качи отново.</p>
            <?php
        } else {
            $students = BigBlueButtonParser::getStudentList($fileContent);
            $students = Student::getByNames($students);

            $student_course_pivots_ids = StudentCoursePivot::getIDs($students, $this->ROUTE['URL_PARAMS']['id']);

            $presence = Presence::storeList($stamp, $student_course_pivots_ids);
            // TODO: students may be in the BBB text file but not in the students table
            header("Location: /course/" . $this->ROUTE['URL_PARAMS']['id']);
        }
    }
    ?>
    <form action="import-bbb" method="post" enctype="multipart/form-data">
        <input type="file" name="presence_list">
        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
        <label>
            <input type="checkbox" name="confirm" value="true"/>
            <p>Ако списъка вече е импортиран, искате ли да го качите отново?</p>
        </label>
        <input type="submit" value="Качване" name="import"/>
    </form>
</section>

<a href="/logout">Logout</a>


</body>
</html>


