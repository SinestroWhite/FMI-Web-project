<html>
<head>
    <title>PHP Test</title>
</head>
<body>
<form action="register" method="post">
    <label for="name">Name</label>
    <input id="name" type="text" name="name"/>
    <label for="email">Email</label>
    <input id="email" type="email" name="email"/>
    <label for="expertise">Expertise</label>
    <input id="expertise" type="text" name="expertise"/>
    <label for="pass">Password</label>
    <input id="pass" type="password" name="password"/>
    <label for="conf-pass">Confirm password</label>
    <input id="conf-pass" type="password" name="conf_password"/>

    <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
    <input type="submit" name="register" value="Submit"/>
</form>

<a href="login">I already have an account.</a>
</body>
</html>
<?php
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
