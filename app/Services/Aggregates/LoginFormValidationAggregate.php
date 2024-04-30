<?php

namespace App\Services\Aggregates;

use App\Services\Implementation\Validators\EmailValidator;
use App\Services\Implementation\Validators\PasswordValidator;
use App\Services\Implementation\Validators\registeredUserValidator;
use App\Models\User;

class LoginFormValidationAggregate
{
    private array $validators;
    private User $user;
    private bool $isRegisteredUser;
    private string $action;

    public function __construct($dataToValidate, $action)
    {
        $this->user = new User();
        $this->isRegisteredUser = $this->user->isRegistered($dataToValidate['email']);
        $this->action = $action;

        $this->validators = [
            'email' => new EmailValidator($dataToValidate['email']),
            'checkEmail' => new registeredUserValidator($this->isRegisteredUser, $this->action),
            'password' => new PasswordValidator($dataToValidate['password']),
        ];
    }

    public function getValidationResult(): array
    {
        $errors = array_map(fn($validator) => $validator->validate(),
            $this->validators);

        return array_filter($errors, fn($errorMessage) => $errorMessage != "");
    }
}