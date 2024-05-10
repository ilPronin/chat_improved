<?php

use App\Controllers\Auth;
use App\Controllers\Messenger;
use App\Services\Implementation\Router;

Router::page('/', 'home');
Router::page('/login', 'login');
Router::page('/register', 'register');
Router::page('/messenger', 'messenger');

//в post передается:  путь на action-страницу, класс, метод, $_POST?, $_FILES?
Router::post('/auth/register', Auth::class, 'register', true, true);
Router::post('/auth/login', Auth::class, 'login', true);

Router::post('/messenger/search', Messenger::class, 'search', true);
Router::post('/messenger/searchNewUser', Messenger::class, 'searchNewUser', true);
Router::post('/messenger/addNewUser', Messenger::class, 'addNewUser', true);
Router::post('/messenger/renderUserToTalk', Messenger::class, 'renderUserToTalk', true);
Router::post('/messenger/sendMessage', Messenger::class, 'sendMessage', true, true);
Router::post('/messenger/renderMessages', Messenger::class, 'renderMessages', true);
Router::post('/messenger/logout', Messenger::class, 'logout');

Router::enable();