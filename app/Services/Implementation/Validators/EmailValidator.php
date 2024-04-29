<?php

namespace App\Services\Implementation\Validators;

use App\Services\Interfaces\IValidator;

class EmailValidator implements IValidator
{
    private string $email;

    public function __construct($email)
    {
        $this->email = htmlspecialchars($email);
    }

    public function validate(): string
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return 'Некорректный адрес электронной почты.';
        }

        return "";
    }
}
