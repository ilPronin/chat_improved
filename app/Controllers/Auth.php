<?php

namespace App\Controllers;

use App\DB\Database;
use App\Services\Implementation\Helper;
use App\Services\Implementation\Router;
use App\Services\Aggregates\RegisterFormValidationAggregate;
//use App\Services\Validator;
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

        if (count($errors)) {
            echo "<pre>";
            var_dump($_SESSION['validate']);
            var_dump($avatar);
            var_dump($avatar !== null);
            echo "</pre>";
            Router::redirect('/register');
        }

        $avatarPath = Helper::uploadAvatar($avatar);
        var_dump($avatarPath);

        $user = new User();
        $user->register($data, $avatarPath);

//        $db = new DatabaseTrait();
//
//        $query
//            = "INSERT INTO users (name, email, avatar, password)
//            VALUES (:name, :email, :avatar, :password)";
//        $params = [
//            'name' => $name,
//            'email' => $email,
//            'avatar' => $avatarPath,
//            'password' => password_hash($password, PASSWORD_DEFAULT)
//        ];
//
//        $db->addData($query, $params);
        Router::redirect('/login');
//        echo "Валидация прошла успешно. Пользователь добавлен!";

        session_destroy();
    }
}

//TODO: реализовать вывод ошибки, если пользователь уже существует.