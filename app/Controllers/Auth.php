<?php

namespace App\Controllers;

use App\Services\Implementation\Helper;
use App\Services\Implementation\Router;
use App\Services\Aggregates\RegisterFormValidationAggregate;
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
        $user->isRegisteredMessage($data['email']);

        if (count($errors)) {
            Router::redirect('/register');
        }

        $avatarPath = Helper::uploadAvatar($avatar);
        $user->register($data, $avatarPath);
        Router::redirect('/login');

        session_destroy();
    }
}