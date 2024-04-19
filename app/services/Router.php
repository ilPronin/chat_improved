<?php

namespace App\Services;

class Router
{
    private static array $list = [];

    public static function page($uri, $pageName)
    {
        self::$list[] = [
            "uri" => $uri,
            "pageName" => $pageName
        ];
    }

    public static function enable()
    {
        $page = $_GET['q'];

        foreach (self::$list as $route) {
            if ($route['uri'] === '/' . $page){
                require_once 'views/pages/' . $route['pageName'] . '.php';
            }
        }
    }
}
