<?php

namespace App\Services\Implementation;

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

    public static function post(
        $uri,
        $class,
        $method,
        $formdata = false,
        $files = false
    ): void {
        self::$list[] = [

            "uri" => $uri,
            "class" => $class,
            "method" => $method,
            "post" => true,
            "formdata" => $formdata,
            "files" => $files
        ];
    }

    public static function redirect(string $path)
    {
        header("Location: $path");
        die();
    }

    public static function enable(): void
    {
        $page = $_GET['q'] ?? '';

        foreach (self::$list as $route) {
            if ($route["uri"] === '/' . $page) {
                if (isset($route['post']) && $route["post"] === true
                    && $_SERVER["REQUEST_METHOD"] === "POST"
                ) {
                    self::callWithParams(
                        $route,
                        $route['formdata'],
                        $route['files']
                    );
                } else {
                    require_once 'views/pages/' . $route['pageName'] . '.php';
                }
                die();
            }
        }
        self::ShowPageNotFound();
    }

    private static function ShowPageNotFound(): void
    {
        require_once "views/errors/404.php";
    }

    private static function callWithParams($route, $post, $files): void
    {
        $action = new $route["class"];
        $method = $route["method"];
        if ($post && $files) {
            $action->$method($_POST, $_FILES);
        } elseif ($post && !$files) {
            $action->$method($_POST);
        } else {
            $action->$method();
        }
    }
}
