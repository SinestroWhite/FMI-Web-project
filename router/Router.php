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
        foreach ($this->routes as $route) {
            // /course/2 ==? /course/:id
            if ($this->match($route->path, $this->path)) {
                $this->routeGuard($route);
                return;
            }
        }

        // Redirect the user to the "not found" page
        header("Location: 404");
    }

    public static function isLoggedIn() {
        return isset($_SESSION["login_time"]);
    }

    private function routeGuard($route) {
        if (isset($route->meta)) {
            if ($this->isLoggedIn()) {
                if ($route->meta->auth == "prevent") {
                    // Redirect logged in user to the dashboard
                    header("Location: /dashboard");
                    return;
                }
            } else {
                if ($route->meta->auth == "required") {
                    // Redirect not logged in user to the login page
                    header("Location: /login");
                    return;
                }
            }
        }
        // Load the requested page
        require_once APP_ROOT . "views/" . $route->view . ".php";
    }

    private function match($route, $subject): bool {
        preg_match_all("#/:([^/]+)/?#", $route, $output);
        $parameter_names = $output[1];

        $search_pattern = "#^". preg_replace("#/:[^/]+(/?)#", "/([^/]+)$1", $route) . "/?$#";
        preg_match_all($search_pattern, $subject, $out);

//        var_dump($out);
        $result = [];
        $i = 1;
        foreach ($parameter_names as $name) {
            // TODO: Fix udefined $out[$i][0]
//            if (isset($out[$i][0]) && count($out[$i][0]) != 0) {
                $result[$name] = $out[$i][0];
//            }
            ++$i;
        }
//        var_dump($result);

        $_ROUTE["URL_PARAMS"] = $result;

        return preg_match($search_pattern, $subject);
    }
}
