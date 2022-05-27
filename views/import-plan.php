
<section class="container data-section">
    <h1>Импортиране на предварителен план</h1>
    <p><a href="<?= '/course/' . Router::$ROUTE['URL_PARAMS']['id'] ?>">Назад към курса</a></p>
    <form action="import-plan" method="post" enctype="multipart/form-data">
        <label>
            Дата на представяне
            <input type="date" name="date" required/>
        </label>
        <label>
            Предварителен план (копиран от Google Spreadsheets)
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

<?php
if (isset($_POST["import"])) {
    if(empty($_POST['plan']) || empty($_POST['date'])) {
        throw new IncompleteFormError();
    }

    if(!empty($_POST['configuration'])) {
        $config = json_decode($_POST['configuration']);
        $parser = new PlanCSVParser($config->field_delimiter, $config->line_delimiter, $config->skip_header_rows, $config->validate);
    } else {
        $parser = new PlanCSVParser('\t', '\n', '1', 'true');
    }

    $plan = $_POST['plan'];
    $date = $_POST['date'];
    $parser->processPlan($plan, $date);

    header("Location: /course/" . Router::$ROUTE['URL_PARAMS']['id']);
}
?>
