<?php

namespace App\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Services\Aggregates\FileValidationAggregate;
use App\Services\Implementation\Helper;

class Messenger
{
    public function search()
    {
        session_start();

        $user = new User();
        if (!empty($_POST['key'])) {
            $chat = new Chat();
            $key = "%{$_POST['key']}%";
            $usersList = $chat->searchChat($key, $_SESSION['user']['id']);

            foreach ($usersList as $chat) {
                if (isset($chat)) {
                $html = '<div class="item">
                <img src=' . $chat['avatar'] . ' alt="">
                <div class="item__info">
                <span>' . $chat['name'] . '</span></div>';
                    if (Helper::last_seen($chat['last_seen']) == 'Онлайн') {
                        $html .= '<div><div class="online"></div></div></div>';
                    } else {
                        $html .= '<div class="offline"><p>' . Helper::last_seen(
                                $chat['last_seen']
                            ) . '</p></div></div>';
                    }
                    echo $html;
                }
            }
        } else {
            $chats = $user->getChat($_SESSION['user']['id']);
            if (!empty($chats)) {
                foreach ($chats as $chat) {
                    if (isset($chat)) {
                        $html = '<div class="item">
                <img src=' . $chat['avatar'] . ' alt="">
                <div class="item__info">
                <span>' . $chat['name'] . '</span></div>';
                        if (Helper::last_seen($chat['last_seen']) == 'Онлайн') {
                            $html .= '<div class="online"></div></div>';
                        } else {
                            $html .= '<div class="offline"><p>'
                                . Helper::last_seen(
                                    $chat['last_seen']
                                ) . '</p></div></div>';
                        }
                        echo $html;

                    }
                }
            } else {
                $html
                    = '<h2 style="padding: 20px">У вас пока что нет сообщений</h2>';
                echo $html;
            }
        }
    }

    public function searchNewUser()
    {
        session_start();
        $chat = new Chat();
        $key = "%{$_POST['key']}%";

        if (!empty($_POST['key']) && !empty($chat->searchUser($key))) {
            $newUsers = $chat->searchUser($key);

            foreach ($newUsers as $user) {
                if ($user['id'] === $_SESSION['user']['id']) {
                    echo "";
                    continue;
                }
                if (!empty($user)) {
                    $html = '
                        <div class="newUser"><div class="detail">
                            <input name="userId" type="hidden" value=' . $user["id"] . ' />
                            <img src=' . $user['avatar'] . ' alt="">
                            <span>' . $user['name'] . '</span>
                        </div>
                        <button id=' . $user['id'] . ' class="add-user-button">Добавить</button></div>';
                    echo $html;
                }
            }
        } else {
            echo "SEARCH";
        }
    }

    public function addNewUser(){
        session_start();
        $currentUserId = $_SESSION['user']['id'];
        $newUserId = $_POST['userId'];
        $chat = new Chat();
        $chat->createNewChat($currentUserId, $newUserId);
    }

    public function renderUserToTalk()
    {
        session_start();
        $user = new User();
        $userToTalkId = $_POST['userId'];
        $userToTalk = $user->getCurrentUser($userToTalkId);
        $_SESSION['userToTalk'] = $userToTalkId;
        $html = '
                <div class="user">
                    <img src='. $userToTalk["avatar"] .' alt="avatar">
                    <div class="currentUserInfo">
                        <span>'. $userToTalk['name'] .'</span>
                        <p>'. Helper::last_seen($userToTalk['last_seen']) .'</p>
                    </div>
                </div>';
        echo $html;
    }

    public function sendMessage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $chat = new Chat();

            $recipient = $_SESSION['userToTalk'];
            $sender = $_SESSION['user']['id'];
            $user = new User();
            $userToTalk = $user->getCurrentUser($recipient);

            $file = $_FILES['file']['error'] == UPLOAD_ERR_OK ? $_FILES['file'] : null;
            $sentMessage = htmlspecialchars($_POST['message']);

            $validator = new FileValidationAggregate($file);
            $error = $validator->getValidationResult();

            $filePath = null;

            echo '<pre>';
            var_dump($file);
            var_dump($error);
            echo $sentMessage;
            echo $recipient;
            echo $sender;
            echo '</pre>';

            if (empty($error) && $file !== null){
                $filePath = Helper::uploadFile($file);
            }

            $chat->sendMessage($sender, $recipient, $sentMessage, $filePath);
        }
    }

    public function renderMessages()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $chat = new Chat();

            $recipient = $_SESSION['userToTalk'];
            $sender = $_SESSION['user']['id'];
            $user = new User();
            $userToTalk = $user->getCurrentUser($recipient);

            $messages = $chat->getMessages($sender, $recipient);

            foreach ($messages as $message) {
                if ($message['sender'] === $sender){
                    $messageToHTMl = '';
                    $messageToHTMl =
                        '<div class="message own">
                            <div class="text">';
                    if ($message['file'] !== null){
                        if (str_ends_with($message['file'], 'txt')){
                            $messageToHTMl .= '<p><a href="'. $message['file'] .'" download>'. $message['file'] .'</a></p>';
                        }else {
                            $messageToHTMl .= '<img src="'. $message['file'] .'" alt="">';
                        }
                    }
                    $messageToHTMl .= '
                                <p>'. $message['message'] .'</p>
                                <span>'. Helper::formatDate($message['date']) .'</span>
                            </div>
                        </div>';
                }else {
                    $messageToHTMl =
                        '<div class="message">
                            <img src="'. $userToTalk['avatar'] .'" alt="">
                            <div class="text">';
                    if ($message['file'] !== null){
                        if (str_ends_with($message['file'], 'txt')){
                            $messageToHTMl .= '<p><a href="'. $message['file'] .'" download>'. $message['file'] .'</a></p>';
                        }else {
                            $messageToHTMl .= '<img src="'. $message['file'] .'" alt="">';
                        }
                    }
                    $messageToHTMl .= '
                                <p>'. $message['message'] .'</p>
                                <span>'. Helper::formatDate($message['date']).'</span>
                            </div>
                        </div>';
                }
                echo $messageToHTMl;
            }
        }
    }
}