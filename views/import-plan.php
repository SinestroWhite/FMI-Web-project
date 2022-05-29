
<section class="container data-section">
    <h1>
        <a class="icon-back is-link" href="<?= '/course/' . Router::$ROUTE['URL_PARAMS']['id'] ?>"><i class="fa-solid fa-chevron-left"></i></a>
        Импортиране на предварителен план
    </h1>
    <form action="import-plan" method="post" enctype="multipart/form-data">
        <label>
            Дата на представяне
            <input class="input is-link" type="date" name="date" required value="<?= $_POST['date'] ?>"/>
        </label>
        <label>
            Предварителен план
            <textarea class="textarea large is-link" name="plan" required><?= $_POST['plan'] ?></textarea>
        </label>
        <label>
            Конфигурационни данни
            <textarea class="textarea small is-link" name="configuration" placeholder="{&quot;field_delimiter&quot;:&quot;\t&quot;, &quot;line_delimiter&quot;:&quot;\n&quot;, &quot;skip_header-rows&quot;:&quot;0&quot;, &quot;validate&quot;:&quot;true&quot;}"><?= $_POST['configuration'] ?></textarea>
        </label>
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
        <input class="button is-link" type="submit" value="Импортиране" name="import"/>
    </form>
</section>

<?php
if (isset($_POST["import"])) {
    if (empty($_POST['plan']) || empty($_POST['date'])) {
        throw new IncompleteFormError();
    }

    if (!empty($_POST['configuration'])) {
        $config = json_decode($_POST['configuration']);
        $parser = new PlanCSVParser($config->field_delimiter, $config->line_delimiter, $config->skip_header_rows, $config->validate);
    } else {
        $parser = new PlanCSVParser("\t", "\n", '0', 'true');
    }

    $plan = $_POST['plan'];
    $date = $_POST['date'];
    $parser->processPlan($plan, $date);

    header("Location: /course/" . Router::$ROUTE['URL_PARAMS']['id']);
}
?>
