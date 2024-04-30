<?php

use App\Controllers\Auth;
use App\Services\Implementation\Router;

Router::page('/', 'home');
Router::page('/login', 'login');
Router::page('/register', 'register');
Router::page('/messenger', 'messenger');

//в post передается:  путь на action-страницу, класс, метод, $_POST?, $_FILES?
Router::post('/auth/register', Auth::class, 'register', true, true);
Router::post('/auth/login', Auth::class, 'login', true);

Router::enable();