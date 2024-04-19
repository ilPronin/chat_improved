<?php

namespace App\Services;

class Router
{
    private static array $list = [];

    public static function page($uri, $pageName): void
    {
        self::$list[] = [
            "uri" => $uri,
            "pageName" => $pageName
        ];
    }

    public static function enable(): void
    {
        $page = $_GET['q'];

        foreach (self::$list as $route) {
            if ($route['uri'] === '/' . $page){
                require_once 'views/pages/' . $route['pageName'] . '.php';
                echo $page;
                exit();
            }
            echo "ну и тут";
            self::ShowPageNotFound();
        }
    }

    private static function ShowPageNotFound(): void
    {
        require_once "views/errors/404.php";
    }
}
