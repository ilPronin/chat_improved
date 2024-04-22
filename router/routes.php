<?php
use App\Services\Router;
use App\Controllers\Auth;

Router::page('/', 'home');
Router::page('/login', 'login');
Router::page('/register', 'register');

//в post передается:  путь на action-страницу, класс, метод, $_POST?, $_FILES?
Router::post('/auth/register', Auth::class, 'register', true, true);

Router::enable();