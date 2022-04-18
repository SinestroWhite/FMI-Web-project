<html>
<head>
    <title>Import Presence</title>
</head>
<body>
<section class="data-section">
    <h1>Импортиране на присъсъствен списък</h1>
    <form action="import" method="post" enctype="multipart/form-data">
        <input type="file" name="presence_list">
        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
        <input type="submit" value="Качване" name="import"/>
    </form>
</section>

<a href="logout">Logout</a>

</body>
</html>

<?php
if (isset($_POST["import"])) {

    $filename = $_FILES['presence_list']['tmp_name'];
//     $ext = pathinfo($filename, PATHINFO_EXTENSION);
//
//     if ($ext != "txt") {
//         throw new InvalidFileFormatError();
//     }

    if ($_FILES["presence_list"]["size"] > 500000) {
        throw new FileTooLargeError();
    }

    $fileContent = file_get_contents($filename);

    $regexTimestamp = "/([1-9]|1[0-2])\/([1-9]|1[0-9]|2[0-9]|3[0|1])\/(\d{4}):([0-9]|1[0-2]):([0-5]?[0-9]):([0-5]?[0-9]) (AM|PM)/";
    preg_match_all($regexTimestamp, $fileContent, $matches);

    $month = $matches[1][0];
    $day = $matches[2][0];
    $year = $matches[3][0];
    $hour = $matches[4][0];
    $minute = $matches[5][0];
    $second = $matches[6][0];

    $regexStudentList = "/Sorted by first name:\r\n(([^\r]|\r)*)\n  \r\n\r\nSorted by last name:/";
    preg_match_all($regexStudentList, $fileContent, $matches_st);
//    var_dump($matches_st);
    $studentList = $matches_st[1][0];
    $res = explode("\n", $studentList);
//
//    // TODO: Attempt to fix the bad way
//    foreach ($res as $index => $student) {
//        if (ctype_space($student) || $student == "") {
//            unset($res[$index]);
//        }
//    }
//
    var_dump($res);

//    $connection = (new DB())->getConnection();
//    $sql = "INSERT INTO presences (presence_time, name) VALUES (?, ?)";
//
//    $stmt = $connection->prepare($sql);
//
//    foreach ($res as $student) {
//
//    }
//
//    $connection = (new DB())->getConnection();
//    $sql = "INSERT INTO presences (presence_time, name) VALUES (?, ?)";
//
//    $stmt = $connection->prepare($sql);
//    $result = $stmt->execute
}
?>
