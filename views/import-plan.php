<html>
<head>
    <title>Import Plan</title>
</head>

<style>
    form, input, textarea {
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
    <h1>Импортиране на предварителен план</h1>
    <p><a href="<?= '/course/' . $this->ROUTE['URL_PARAMS']['id'] ?>">Назад към курса</a></p>
    <form action="import-plan" method="post" enctype="multipart/form-data">
        <label>
            Дата на представяне
            <input type="date" name="date" required/>
        </label>
        <label>
            Предварителен план (копиран от Google Spreadsheet)
            <textarea name="plan" required></textarea>
        </label>
        <label>
            Конфигурационни данни
            <textarea name="configuration" placeholder="'field-delimiter':'\t', 'line-delimiter':'\n', 'skip-header-rows':3, 'validate':'true'"></textarea>
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
    if(empty($_POST['plan']) || empty($_POST['date'])) {
        throw new IncompleteFormError();
    }

    if(!empty($_POST['configuration'])) {
        $config = json_decode($_POST['configuration']);
        PlanCSVParser parser = new PlanCSVParser($config->field-delimiter, $config->line-delimiter, $config->skip-header-rows, $config->validate);
    }

    $plan = $_POST['plan'];
    $date = $_POST['date'];
       parser->processPlan($plan, $date);

    header("Location: /course/" . $this->ROUTE['URL_PARAMS']['id']);
}
?>
