<?php

namespace App\Controllers;

use App\Services\Validator;
use App\Services\Router;

class Auth
{
    public function register($data, $files)
    {
        session_start();
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $avatar = $_FILES['avatar']['error'] == 0 ? $_FILES['avatar'] : null;
        $password = htmlspecialchars($_POST['password']);
        $passwordConfirmation = htmlspecialchars(
            $_POST['password_confirmation']
        );
        $avatarPath = null;

        $validator = new Validator(
            $name, $email, $password, $passwordConfirmation, $avatar
        );
        $errors = $validator->setValidationErrors();
        $_SESSION['validate'] = $errors;

        if (count($errors)) {
            Router::redirect('/register');
        }

        echo "Валидация прошла успешно, движемся дальше!";
    }
}