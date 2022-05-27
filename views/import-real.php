
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
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
        <input type="submit" value="Качване" name="import"/>
    </form>
</section>

<?php
if (isset($_POST["import"])) {
    $plan = $_POST['plan'];
    $date = $_POST['date'];
    PlanCSVParser::processReal($plan, $date);

    header("Location: /course/" . Router::$ROUTE['URL_PARAMS']['id']);
}
?>
