<?php

namespace App\Controllers;

use App\DB\Database;
use App\Services\Helper;
use App\Services\Router;
use App\Services\Validator;

class Auth
{
    public function register($data, $files): void
    {
        session_start();

        $name = htmlspecialchars($data['name']);
        $email = htmlspecialchars($data['email']);
        $avatar = $files['avatar']['error'] == 0 ? $files['avatar'] : null;
        $password = htmlspecialchars($data['password']);
        $passwordConfirmation = htmlspecialchars(
            $data['password_confirmation']
        );
        $avatarPath = null;

        $validator = new Validator(
            $name, $email, $password, $passwordConfirmation, $avatar
        );
        $errors = $validator->getValidationErrors();
        $_SESSION['validate'] = $errors;

        if (count($errors)) {
            Router::redirect('/register');
        }

        if ($avatar !== null) {
            $avatarPath = Helper::uploadAvatar($avatar);
        }

        $db = new Database();

        $query
            = "INSERT INTO users (name, email, avatar, password)
            VALUES (:name, :email, :avatar, :password)";
        $params = [
            'name' => $name,
            'email' => $email,
            'avatar' => $avatarPath,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $db->addData($query, $params);
        Router::redirect('/login');
        echo "Валидация прошла успешно. Пользователь добавлен!";
    }
}

//TODO: реализовать вывод ошибки, если пользователь уже существует.