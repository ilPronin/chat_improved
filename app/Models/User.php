<?php

namespace App\Models;

//use App\DB\Database;

use App\Services\Traits\DatabaseTrait;

class User
{
    use DatabaseTrait;

    public function __construct()
    {
        $this->setConnection();
    }

    public function register($data, $avatarPath){
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->prepare('INSERT INTO users (name, email, avatar, password) VALUES (:name, :email, :avatar, :password)');
        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $avatarPath,
            'password' => $hashedPassword
        ]);

    }
}