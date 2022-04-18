<html>
    <head>
        <title>Gradeview | Login</title>
    </head>
    <body>

    <form action="login" method="post">
        <label for="email">Email</label>
        <input id="email" type="email" name="email"/>
        <label for="pass">Password</label>
        <input id="pass" type="password" name="password"/>

		<input type="submit" name="login" value="Submit"/>
	</form>

	<a href="register">Don't have an account?</a>
  </body>
</html>

<?php
	if(isset($_POST['login'])) {
		$email         = $_POST['email'];
		$password      = $_POST['password'];

        $user = User::verifyCredentials($email, $password);
        $_SESSION['login_time'] = time();
        $_SESSION['id'] = $user["id"];
        $_SESSION['name'] = $user["name"];
        $_SESSION['email'] = $user["email"];
        $_SESSION['expertise'] = $user['expertise'];

//         session_unset();
//         var_dump($_SESSION);
        header('Location: dashboard');
	}
?>
