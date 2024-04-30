<?php

namespace App\Controllers;

    use App\Services\Implementation\Helper;
use App\Services\Implementation\Router;
use App\Services\Aggregates\RegisterFormValidationAggregate;
use App\Services\Aggregates\LoginFormValidationAggregate;
use App\Models\User;

class Auth
{
    public function register($data, $files): void
    {
        session_start();

        $avatar = Helper::getLoadedAvatar($files['avatar']);
        $validator = new RegisterFormValidationAggregate($data, $avatar);
        $errors = $validator->getValidationResult();

        $_SESSION['validate'] = $errors;

        Helper::setOldValue('name', $_POST['name']);
        Helper::setOldValue('email', $_POST['email']);

        $user = new User();
        $user->isUserRegisteredMessage($data['email'], 'register');
        if (count($_SESSION['validate'] )) {
//            echo "<pre>";
//            var_dump($_SESSION['validate']);
//            echo "</pre>";
//            die();
            Router::redirect('/register');
        }

        $avatarPath = Helper::uploadAvatar($avatar);
        $user->register($data, $avatarPath);
        Router::redirect('/login');

        session_destroy();
    }

    public function login($data)
    {
        session_start();

        $validator = new LoginFormValidationAggregate($data, 'login');
        $errors = $validator->getValidationResult();

        $_SESSION['validate'] = $errors;

        Helper::setOldValue('email', $_POST['email']);

        $user = new User();

        if (count($errors)) {
            Router::redirect('/login');
        }

        $currentUser = $user->login($data['email']);

        if (!password_verify($data['password'], $currentUser['password'])){
            $_SESSION['validate']['password'] = 'Неверный пароль';
            Router::redirect('/login');
        }

        $_SESSION['user']['id'] = $currentUser['id'];

        Router::redirect('/messenger');
    }
}