<?php

namespace App\Services\Implementation\Validators;

use App\Services\Interfaces\IValidator;

class AvatarValidator implements IValidator
{
    private ?array $avatar;
    private array $typesOfImage = ['image/jpeg', 'image/png'];

    public function __construct($avatar)
    {
        $this->avatar = $avatar;
    }

    public function validate(): string
    {
        if (empty($this->avatar)){
            return "";
        }elseif (!is_uploaded_file($this->avatar['tmp_name'])) {
            return 'Произошла ошибка при загрузке аватара.';
        } elseif (!in_array($this->avatar['type'], $this->typesOfImage)) {
            return "Изображение имеет неверный тип";
        }

        return "";
    }
}
