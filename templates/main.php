<html>
<head>
    <title>Gradeview
        <?php if (isset(Router::$ROUTE['title'])) {
            echo  "| " . Router::$ROUTE['title'];
        } ?>
    </title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.1.1/css/fontawesome.min.css" integrity="sha384-zIaWifL2YFF1qaDiAo0JFgsmasocJ/rqu7LKYH8CoBEXqGbb9eO+Xi3s6fQhgFWM" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/assets/css/styles.css"/>
    <?php
        foreach (Router::$ROUTE['css'] as $link) {
            ?>
                <link rel="stylesheet" type="text/css" href="<?= $link ?>"/>
            <?php
        }
    ?>
</head>
<body>
    <header>
        <nav class="nav">
            <div class="container">
                <div class="grid">
                    <div class="left">
                        <h1><a class="no-decoration title" href="/">Gradeview</a></h1>
                    </div>
                    <div class="right">
                        <?php
                        if (Router::isLoggedIn()) {
                            ?>
                            <a class="link" href="/dashboard">Dashboard</a>
                            <a class="link" href="/logout">Logout</a>
                            <?php
                        } else {
                            ?>
                            <a class="link" href="/login">Login</a>
                            <a class="link" href="/register">Register</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <?php require_once Router::$ROUTE['view']; ?>
</body>
</html>
