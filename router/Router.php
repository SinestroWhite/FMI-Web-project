<?php


class Router {
    private $path;

    public function __constructor() {
        $path = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
        echo $path;
    }
}

$routes = [
    [
        "path" => "/",
        "view" => "welcome",
    ],
    [
        "path" => "/login",
        "view" => "login",
        "meta" => [
            "auth" => "prevent"
        ]
    ],
    [
        "path" => "/register",
        "view" => "register",
        "meta" => [
            "auth" => "prevent"
        ]
    ],
    [
        "path" => "/dashboard",
        "view" => "dashboard",
        "meta" => [
            "auth" => "required"
        ]
    ]
];
