<?php

namespace App\Services\Implementation;

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

            return "uploads/$fileName";
        }
        return null;
    }

    public static function getLoadedAvatar(array $avatar)
    {
        return $avatar['error'] === UPLOAD_ERR_OK ? $avatar : null;
    }

}