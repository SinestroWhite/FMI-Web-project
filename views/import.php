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
    $fileContent = BigBlueButtonParser::fileValidation($_FILES['presence_list']);

    $stamp = BigBlueButtonParser::getTimestamp($fileContent);
    $presence = new Presence($stamp, "web");
    $presence->store();

    $students = BigBlueButtonParser::getStudentList($fileContent);
    Student::storeList($students);

    StudentPresencePivot::storeList($students, $presence->getId());

}
?>
