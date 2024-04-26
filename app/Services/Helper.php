<?php

namespace App\Services;

class Helper
{
    public static function uploadAvatar($avatar)
    {
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

        return "uploads/$fileName";
    }
}