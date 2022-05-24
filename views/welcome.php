<html>
<head>
    <title>Gradeview</title>
</head>
<body>
<p>Welcome to Gradeview.</p>
<?php
    if (Router::isLoggedIn()) {
        ?>
            <a href="/dashboard">Dashboard</a>
        <?php
    } else {
        ?>
            <a href="/login">Login</a>
        <?php
    }
?>
</body>
</html>
