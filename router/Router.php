<?php

class Router {
    private $path, $routes;

    public function __construct() {
        $this->path = $_SERVER["REQUEST_URI"];
        // path to the routes file
        $file = APP_ROOT . "router/routes.json";
        // put the content of the file in a variable
        $data = file_get_contents($file);
        // JSON decode
        $this->routes = json_decode($data);
    }

    public function locate() {
        session_start();
        foreach ($this->routes as $route) {
            if ($this->path == $route->path) {
                if ($this->isLoggedIn()) {
                    if ($route->meta->auth == "prevent") {
                        // Redirect logged in user to the dashboard
                        header("Location: dashboard");
                        return;
                    }
                } else {
                    if ($route->meta->auth == "required") {
                        // Redirect not logged in user to the login page
                        header("Location: login");
                        return;
                    }
                }
                // Load the requested page
                require_once APP_ROOT . "views/" . $route->view . ".php";
                return;
            }
        }

        require_once APP_ROOT . "views/404.php";
    }

    private function isLoggedIn() {
        return isset($_SESSION["login_time"]);
    }
}
