<?php

namespace App\Services\Implementation\Validators;

use App\Services\Interfaces\IValidator;

class PasswordConfirmationValidator implements IValidator
{
    private string $password;
    private string $passwordConfirmation;

    public function __construct($password, $passwordConfirmation)
    {
        $this->password = $password;
        $this->passwordConfirmation =   $passwordConfirmation;
    }

    public function validate(): string
    {
        if ($this->password !== $this->passwordConfirmation) {
            return 'Пароли не совпадают.';
        }

        return "";
    }
}