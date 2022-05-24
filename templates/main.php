<html>
<head>
    <title>Gradeview
        <?php if (isset($this->ROUTE['title'])) {
            echo  "| " . $this->ROUTE['title'];
        } ?>
    </title>

    <link rel="stylesheet" type="text/css" href="/assets/css/styles.css"/>
    <?php
        foreach ($this->ROUTE['css'] as $link) {
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

    <?php require_once $this->ROUTE['view']; ?>
</body>
</html>
