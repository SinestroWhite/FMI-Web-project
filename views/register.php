<div class="container">
    <h2>Регистрация</h2>

    <form action="register" method="post">
        <label for="name">Име</label>
        <input class="input is-link" id="name" type="text" name="name"/>
        <label for="email">Електронна поща</label>
        <input class="input is-link" id="email" type="email" name="email"/>
        <label for="expertise">Специалност</label>
        <input class="input is-link" id="expertise" type="text" name="expertise"/>
        <label for="pass">Парола</label>
        <input class="input is-link" id="pass" type="password" name="password"/>
        <label for="conf-pass">Потвърдете паролата</label>
        <input class="input is-link" id="conf-pass" type="password" name="conf_password"/>

        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
        <input class="button is-link" type="submit" name="register" value="Регистрация"/>
    </form>

    <a class="is-link" href="/login">Вече имате акаунт?</a>
</div>
<?php
// TODO: Add validations everywhere
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $expertise = $_POST['expertise'];
    $password = $_POST['password'];
    $conf_password = $_POST['conf_password'];

    $user = new User($name, $email, $expertise, $password, $conf_password);
    $user->store();
    header('Location: login');
}
?>
