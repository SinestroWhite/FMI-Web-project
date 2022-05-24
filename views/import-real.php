<html>
<head>
    <title>Import Real Plan</title>
</head>

<style>
    form, input, textarea, select {
        display: block;
    }
    input[type="submit"] {
        margin: 10px 0;
    }
    textarea {
        width: 800px;
        height: 600px;
    }
</style>
<body>
<section class="data-section">
    <h1>Импортиране на реален план</h1>
    <p><a href="<?= '/course/' . $_ENV['URL_PARAMS']['id'] ?>">Назад към курса</a></p>
    <form action="import-real" method="post" enctype="multipart/form-data">
        <label for="dates">Дата на представяне</label>
        <select name="date" id="dates">
            <?php
                $dates = TimeTable::getDates($_ENV['URL_PARAMS']['id']);
                foreach($dates as $datum) {
                    ?>
                        <option value="<?= $datum['date'] ?>"><?= $datum['date'] ?></option>
                    <?php
                }
            ?>
        </select>
        <label>
            Реален план (копиран от Google Spreadsheet)
            <textarea name="plan" required></textarea>
        </label>
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
        <input type="submit" value="Качване" name="import"/>
    </form>
</section>

<a href="/logout">Logout</a>

</body>
</html>

<?php
if (isset($_POST["import"])) {
    $plan = $_POST['plan'];
    $date = $_POST['date'];
    PlanCSVParser::processReal($plan, $date);

    header("Location: /course/" . $_ENV['URL_PARAMS']['id']);
}
?>
