<?php

namespace App\Services\Implementation\Validators;

use App\Services\Interfaces\IValidator;

class PasswordValidator implements IValidator
{
    private string $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function validate(): string
    {
        if ($this->password != trim($this->password)){
            return 'Пароль не должен начинаться и заканчиваться пробелами';
        } elseif (strlen($this->password) < 6 || strlen($this->password) > 128) {
            return 'Пароль должен быть длиной от 6 до 128 символов.';
        }

        return "";
    }
}