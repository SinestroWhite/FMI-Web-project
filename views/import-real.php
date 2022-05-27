
<section class="container data-section">
    <h1>Импортиране на реален план</h1>
    <p><a href="<?= '/course/' . Router::$ROUTE['URL_PARAMS']['id'] ?>">Назад към курса</a></p>
    <form action="import-real" method="post" enctype="multipart/form-data">
        <label for="dates">Дата на представяне</label>
        <select name="date" id="dates">
            <?php
                $dates = TimeTable::getDates(Router::$ROUTE['URL_PARAMS']['id']);
                foreach($dates as $datum) {
                    ?>
                        <option value="<?= $datum['date'] ?>"><?= $datum['date'] ?></option>
                    <?php
                }
            ?>
        </select>
        <label>
            Реален план (копиран от Google Spreadsheets)
            <textarea name="plan" required></textarea>
        </label>
        <label>
            Конфигурационни данни
            <textarea name="configuration" placeholder="{&quot;field_delimiter&quot;:&quot;\t&quot;, &quot;line_delimiter&quot;:&quot;\n&quot;, &quot;skip_header-rows&quot;:&quot;3&quot;, &quot;validate&quot;:&quot;true&quot;}"></textarea>
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
    $parser->processReal($plan, $date);

    header("Location: /course/" . Router::$ROUTE['URL_PARAMS']['id']);
}

?>
