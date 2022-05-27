<section class="container data-section">
    <h1>
        <a class="icon-back is-link" href="<?= '/course/' . Router::$ROUTE['URL_PARAMS']['id'] ?>"><i
                class="fa-solid fa-chevron-left"></i></a>
        Импортиране на присъствен списък
    </h1>
    <?php
    $courseID = Router::$ROUTE['URL_PARAMS']['id'];
    if (isset($_POST["import"])) {
    if (!file_exists($_FILES['presence-list']['tmp_name']) || !is_uploaded_file($_FILES['presence-list']['tmp_name'])) {
        throw new IncompleteFormError();
    }
    $fileContent = BigBlueButtonParser::fileValidation($_FILES['presence_list']);

    // TODO: fix timestamp 12-hour format to 24-hour format
    $stamp = BigBlueButtonParser::getTimestamp($fileContent);
    if ($_POST['confirm'] != "true" && count(Presence::getByTimestamp($stamp)) != 0) {
        ?>
        <p class="red">Списъкът вече е качен. Моля потвърдете, че искате да се качи отново.</p>
        <?php
    } else {
    $students = BigBlueButtonParser::getStudentList($fileContent);
    $sameNameStudents = Student::getSameNameStudents($students);
    $students = Student::getByNames($students);

            if (count($sameNameStudents) != 0) { ?>
                <form action="import-bbb" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
                    <p>В присъствения списък има студент(и) със съвпадащи имена. Моля изберете кое име с кой факултетен номер е свързано. </p>
                    <?php
                    foreach ($sameNameStudents as $i => $student) {
                        for ($j = 0; $j < $studentNameCounter[$student['name']]; $j++) {
//                            var_dump($studentNameCounter[$student['name']]);
                        ?>
                        <label>
                            <?php echo $student['name']; ?>
                        </label>
                        <select class="select is-link" name="fn<?php echo $i; ?>" id="fn">
                            <?php
                            $fns = json_decode($student['faculty_numbers']);
                            $ids = json_decode($student['ids']);
                            for ($k = 0; $k < count($fns); $k++) {
                                ?>
                                <option value="<?= $ids[$k] ?>"><?= $fns[$k] ?></option>
                                <?php
                            }
                            //                }
                            ?>
                        </select>
                        <?php
                        }
                    }
                    ?>
                    <input class="button is-link" type="submit" value="Поднови" name="importDup"/>
                </form>
                <?php

                for ($i = 0; $i < count($sameNameStudents)  as $student) {
                    $sameNameStudentIds = $_POST[]
                }
            }

            $student_course_pivots_ids = StudentCoursePivot::getIDs($students, $courseID);
            $presence = Presence::storeList($stamp, $student_course_pivots_ids);
            // TODO: students may be in the BBB text file but not in the students table
//            header("Location: /course/" . Router::$ROUTE['URL_PARAMS']['id']);
        }
    } else {
    ?>
    <form action="import-bbb" method="post" enctype="multipart/form-data">
        <div id="file-js-example" class="file has-name">
            <label class="file-label">
                <input class="file-input" type="file" name="presence_list">
                <span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                        Choose a file…
                    </span>
                </span>
                <span class="file-name">
                    <p class="tiny"></p>
                    No file uploaded
                </span>
            </label>
        </div>
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
        <label>
            <input type="checkbox" name="confirm" value="true"/>
            <p>Ако списъкът вече е импортиран, искате ли да го качите отново?</p>
        </label>
        <input class="button is-link" type="submit" value="Качване" name="import"/>
    </form>
    <?php } ?>
</section>

<script>
    const fileInput = document.querySelector('#file-js-example input[type=file]');
    fileInput.onchange = () => {
        if (fileInput.files.length > 0) {
            const fileName = document.querySelector('#file-js-example .file-name');
            fileName.innerHTML = '<p class="tiny"></p>' + fileInput.files[0].name;
        }
    }
</script>




