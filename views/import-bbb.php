<section class="container data-section">
    <h1>Импортиране на присъствен списък</h1>
    <p><a href="<?= '/course/' . Router::$ROUTE['URL_PARAMS']['id'] ?>">Назад към курса</a></p>
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


    if (count($sameNameStudents) != 0) { ?>
    <form action="import-bbb" method="post" enctype="multipart/form-data">
        <input type="file" name="presence_list">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
        <p>В присъствения списък има студент, чието име съвпада с името на друг студент. </p>
        <?php
        foreach ($sameNameStudents as $student) {
            ?>
            <label>
                <?php echo $student['name']; ?>
            </label>
            <select name="fn" id="fn">
                <?php
                foreach ($sameNameStudents as $student) {
                    ?>
                    <option value="<?= $student['faculty_number']?>" name="fn"></option>
                    <?php
                }
                ?>
            </select>
            <?php
            }
            ?>
            <input type="submit" value="Поднови" name="importDup"/>
    </form>
    <?php

     $sameNameStudentsIds =  $_POST['fn']

    }
        $student_course_pivots_ids = StudentCoursePivot::getIDs($students, Router::$ROUTE['URL_PARAMS']['id']);
        $presence = Presence::storeList($stamp, $student_course_pivots_ids);
        // TODO: students may be in the BBB text file but not in the students table
        header("Location: /course/" . Router::$ROUTE['URL_PARAMS']['id']);
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




