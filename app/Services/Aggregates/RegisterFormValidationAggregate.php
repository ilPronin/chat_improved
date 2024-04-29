<?php

namespace App\Services\Aggregates;

use App\Services\Implementation\Validators\AvatarValidator;
use App\Services\Implementation\Validators\EmailValidator;
use App\Services\Implementation\Validators\NameValidator;
use App\Services\Implementation\Validators\PasswordConfirmationValidator;
use App\Services\Implementation\Validators\PasswordValidator;


class RegisterFormValidationAggregate
{
    private array $validators;

    public function __construct($dataToValidate, $fileToValidate)
    {
        $this->validators = [
            'name' => new NameValidator($dataToValidate['name']),
            'email' => new EmailValidator($dataToValidate['email']),
            'avatar' => new AvatarValidator($fileToValidate),
            'password' => new PasswordValidator($dataToValidate['password']),
            'passwordConfirmation' => new PasswordConfirmationValidator(
                $dataToValidate['password'],
                $dataToValidate['password_confirmation']
            )
        ];
    }

    public function getValidationResult(): array
    {
        $errors = array_map(fn($validator) => $validator->validate(),
            $this->validators);

        return array_filter($errors, fn($errorMessage) => $errorMessage != "");
    }
}