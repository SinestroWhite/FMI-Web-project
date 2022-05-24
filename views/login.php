
<div class="container">
    <form action="login" method="post">
        <label for="email">Email</label>
        <input id="email" type="email" name="email"/>
        <label for="pass">Password</label>
        <input id="pass" type="password" name="password"/>

        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
        <input type="submit" name="login" value="Submit"/>
    </form>

    <a href="/register">Don't have an account?</a>
</div>
<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = User::verifyCredentials($email, $password);
    $_SESSION['login_time'] = time();
    $_SESSION['id'] = $user["id"];
    $_SESSION['name'] = $user["name"];
    $_SESSION['email'] = $user["email"];
    $_SESSION['expertise'] = $user['expertise'];

    header('Location: /dashboard');
}
?>
