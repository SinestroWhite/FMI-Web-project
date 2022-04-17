<?php

session_start();
unset($_SESSION["id"]);
unset($_SESSION["name"]);
unset($_SESSION["email"]);
unset($_SESSION["expertise"]);
unset($_SESSION["login_time"]);

header('Location: login');
