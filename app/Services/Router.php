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

    public static function post($uri, $class, $method, $formdata = false, $files = false)
    {
        self::$list[] = [
            "uri" => $uri,
            "class" => $class,
            "method" => $method,
            "post" => true,
            "formdata" => $formdata,
            "files" => $files
        ];
    }

    public static function enable(): void
    {
        $page = $_GET['q'] ?? '';

        foreach (self::$list as $route) {
            if ($route["uri"] === '/' . $page){
                if (isset($route['post']) && $route["post"] === true && $_SERVER["REQUEST_METHOD"] === "POST"){

                    $action  = new $route["class"];
                    $method = $route["method"];
                    if ($route['formdata'] && $route['files'])
                    {
                        $action->$method($_POST, $_FILES);
                    } elseif($route['formdata'] && !$route['files'])
                    {
                        $action->$method($_POST);
                    } else{
                        $action->$method();
                    }
                    die();
                } else {
                    require_once 'views/pages/' . $route['pageName'] . '.php';
                    die();
                }
            }
        }
        self::ShowPageNotFound();
    }

    private static function ShowPageNotFound(): void
    {
        require_once "views/errors/404.php";
    }
}
