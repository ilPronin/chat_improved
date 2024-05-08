<?php

namespace App\Models;
use App\Services\Traits\DatabaseTrait;

class Chat
{
    use DatabaseTrait;

    public function __construct()
    {
        $this->setConnection();
    }

    public function searchChat($username, $user_id): array
    {
        $name = $username;
        $query = 'SELECT * FROM chat WHERE user_1=? OR user_2=? ORDER BY chat_id DESC';
        $stmt = $this->prepare($query);
        $stmt->execute([$user_id, $user_id]);

        if ($stmt->rowCount() > 0)
        {
            $chats = $stmt->fetchAll();
            $user_data = [];

            foreach ($chats as $chat){
                if ($chat['user_1'] == $user_id) {
                    $query2 = 'SELECT id, name, email, avatar, last_seen FROM users WHERE id=? AND name LIKE ?';
                    $stmt2 = $this->prepare($query2);
                    $stmt2->execute([$chat['user_2'], $name]);
                } else {
                    $query2 = 'SELECT id, name, email, avatar, last_seen FROM users WHERE id=? AND name LIKE ?';
                    $stmt2 = $this->prepare($query2);
                    $stmt2->execute([$chat['user_1'], $name]);
                }
                $allChats = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
                if (isset($allChats[0])){
                    $user_data[] = $allChats[0];
                }
            }
            return $user_data;
        }else{
            return [];
        }
    }

    public function searchUser($username): false|array
    {
        $currentUserId = $_SESSION['user']['id'];
        $name = $username;
        $query =
                "Select *
                From users
                Where id != ? and id not in (Select case 
                when user_1 = ? Then user_2
                else user_1
                end as id from chat where user_1 = ? or user_2 = ?)
                and name LIKE ?";
        $stmt = $this->prepare($query);
        $stmt->execute([$currentUserId, $currentUserId,$currentUserId, $currentUserId, $name]);
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $users;
    }

    public function createNewChat($currentUserId, $newUserId): void
    {
        $query = "INSERT INTO chat (user_1, user_2) VALUES (:user_1, :user_2)";
        $stmt = $this->prepare($query);
        $stmt->execute([
            'user_1' => $currentUserId,
            'user_2' => $newUserId
        ]);
    }

    public function sendMessage($sender, $recipient, $message, $file): void
    {
        $query = "INSERT INTO messages (sender, recipient, message, file) VALUES (:sender, :recipient, :message, :file)";
        $stmt = $this->prepare($query);
        $stmt->execute([
            'sender' => $sender,
            'recipient' => $recipient,
            'message' => $message,
            'file' => $file
        ]);
    }

    public function getMessages($sender, $recipient)
    {
        $query =
            "SELECT * FROM messages
            WHERE (sender=? AND recipient=?)
            OR (recipient=? AND sender=?)
            ORDER BY id";
        $stmt = $this->prepare($query);
        $stmt->execute([$sender, $recipient, $sender, $recipient]);

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }
}