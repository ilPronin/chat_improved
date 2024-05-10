<?php

namespace App\Models;

use App\Services\Traits\DatabaseTrait;
use PDO;

class User
{
    use DatabaseTrait;

    public function __construct()
    {
        $this->setConnection();
    }

    public function register($data, $avatarPath): void
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->prepare(
            'INSERT INTO users (name, email, avatar, password) 
        VALUES (:name, :email, :avatar, :password)'
        );
        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $avatarPath,
            'password' => $hashedPassword
        ]);
    }

    public function login(string $email)
    {
        $stmt = $this->prepare('SELECT * FROM users WHERE `email` = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isRegistered($email): bool
    {
        $stmt = $this->prepare(
            'SELECT id FROM users WHERE email = :email LIMIT 1'
        );
        $stmt->execute(['email' => $email]);
        return (bool)$stmt->fetch();
    }

    function getCurrentUser($id)
    {
        $query = 'SELECT * FROM users WHERE id = :id';
        $stmt = $this->prepare($query);
        $stmt->execute(['id' => $id]);
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $user = [];
        }
        return $user;
    }

    function getChat($user_id): array
    {
        $query = 'SELECT * FROM chat WHERE user_1=? OR user_2=? ORDER BY chat_id DESC';
        $stmt = $this->prepare($query);
        $stmt->execute([$user_id, $user_id]);

        if ($stmt->rowCount() > 0) {
            $chats = $stmt->fetchAll();
            $user_data = [];

            foreach ($chats as $chat) {
                if ($chat['user_1'] == $user_id) {
                    $query2 = 'SELECT id, name, email, avatar, last_seen
                               FROM users WHERE id=?';
                    $stmt2 = $this->prepare($query2);
                    $stmt2->execute([$chat['user_2']]);
                } else {
                    $query2 = 'SELECT id, name, email, avatar, last_seen
                               FROM users WHERE id=?';
                    $stmt2 = $this->prepare($query2);
                    $stmt2->execute([$chat['user_1']]);
                }
                $allChats = $stmt2->fetchAll();
                $user_data[] = $allChats[0];
            }
            return $user_data;
        } else {
            return [];
        }
    }

    function lastSeenUpdate($user_id): void
    {
        $query = 'UPDATE users SET last_seen = NOW() WHERE id = ?';
        $stmt = $this->prepare($query);
        $stmt->execute([$user_id]);
    }
}