<?php

namespace App\Controllers;

use App\Services\Helper;
use App\Services\Validator;
use App\Services\Router;
use App\Services\Helper;

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

<<<<<<< HEAD
=======
        var_dump($_FILES['avatar']);
>>>>>>> cdd892a0d6b1065d2bfcd495c8d68e6bfc0cdc8d
        Helper::uploadAvatar($avatar);
        echo "Валидация прошла успешно, движемся дальше!";
    }
}