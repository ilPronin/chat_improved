<?php

namespace App\Services\Implementation;
use DateTime;
use JetBrains\PhpStorm\Language;

class Helper
{
    public static function uploadAvatar($avatar)
    {
        if ($avatar !== null){
            $uploadPath = 'uploads/avatars';

            if(!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $ext = pathinfo($avatar['name'], PATHINFO_EXTENSION);
            $fileName = 'avatar_' . time() . ".$ext";
            $path = "$uploadPath/$fileName";

            if (!move_uploaded_file($avatar['tmp_name'], $path)) {
                die('Ошибка при загрузке фото на сервер');
            }

            return "uploads/avatars/$fileName";
        }
        return 'assets/avatar/defaultAvatar.jpg';
    }

    public static function getLoadedAvatar(array $avatar)
    {
        return $avatar['error'] === UPLOAD_ERR_OK ? $avatar : null;
    }

    public static function setOldValue(string $field, string $value): void
    {
        $_SESSION['old'][$field] = $value;
    }

    public static function getOldValue(string $field): string
    {
        $value = $_SESSION['old'][$field] ?? '';
        unset($_SESSION['old'][$field]);
        return $value;
    }

    public static function last_seen($date_time){
        $timestamp = strtotime($date_time);

        $strTime = array ('сек.', 'мин.', 'час', 'день', 'месяц', 'год');
        $length = array ('60', '60', '24', '30', '12', '10');
        $currentTime = time();
        if ($currentTime >= $timestamp) {
            $diff = time() - $timestamp;
            for ($i = 0; $diff >= $length[$i] && $i < count($length) -1; $i++){
                $diff = $diff / $length[$i];
            }
            $diff = round($diff);
            if ($diff < 59 && $strTime[$i] == 'сек.') {
                return 'Онлайн';
            }
            return 'был(а) в сети ' . $diff . ' ' . $strTime[$i] . ' назад.';
        }
    }

    public static function uploadFile($file)
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $imgExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $docExtensions = ['txt'];
        $path = '';

        if (in_array($extension, $imgExtensions)){
            $uploadPath = 'uploads/images';
            $fileName = 'image_' . time() . ".$extension";
            $path = "$uploadPath/$fileName";
        } elseif (in_array($extension, $docExtensions)){
            $uploadPath = 'uploads/documents';
            $fileName = 'file_' . time() . ".$extension";
            $path = "$uploadPath/$fileName";
        }
        if (!move_uploaded_file($file['tmp_name'], $path)) {
            die('Ошибка при загрузке фото на сервер');
        }
        return $path;
    }

    public static function formatDate($dateForFormat): string
    {
        setlocale(LC_TIME, 'ru_RU');
        $timestamp = strtotime($dateForFormat);
        return date('d.m.Y H:i', $timestamp);
    }

    public static function checkAuth(): void
    {
        if (empty($_SESSION['user']['id'])){
            Router::redirect('/login');
        }
    }
}