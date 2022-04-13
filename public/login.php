<?php
    require("../config/env-parse.php");
    require_once("../models/User.php");
    require_once("../errors/handling/error-handler.php");
?>
<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
      <?php
		if(isset($_POST['login'])) {
			$email         = $_POST['email'];
			$password      = $_POST['password'];

            User::verifyCredentials($email, $password);
		}
	?>
    <form action="login.php" method="post">

  		<label for="email">Email</label>
      <input id="email" type="email" name="email"/>
      <label for="pass">Password</label>
      <input id="pass" type="password" name="password"/>
        
		  <input type="submit" name="login" value="Submit"/>
	</form>
  </body>
</html>