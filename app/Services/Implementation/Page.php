<?php

namespace App\Services\Implementation;

class Page
{
    public static function addHead($title): void
    {
        $tabTitle = $title;
        require_once 'views/components/head.php';
    }

    public static function addComponent($component): void
    {
        require_once 'views/components/' . $component . '.php';
    }
}