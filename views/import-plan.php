<html>
<head>
    <title>Import Plan</title>
</head>
<body>
<section class="data-section">
    <h1>Импортиране на предварителен план</h1>
    <form action="import-plan" method="post" enctype="multipart/form-data">
        <label>
            Предварителен план
            <textarea name="plan"></textarea>
        </label>
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
        <input type="submit" value="Качване" name="import"/>
    </form>
</section>

<a href="logout">Logout</a>

</body>
</html>

<?php
if (isset($_POST["import"])) {
    PlanCSVParser::processPlan($_POST['plan']);
}
?>
