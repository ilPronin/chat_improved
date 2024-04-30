<?php

namespace App\Services\Aggregates;

use App\Models\User;
use App\Services\Implementation\Validators\AvatarValidator;
use App\Services\Implementation\Validators\EmailValidator;
use App\Services\Implementation\Validators\NameValidator;
use App\Services\Implementation\Validators\PasswordConfirmationValidator;
use App\Services\Implementation\Validators\PasswordValidator;
use App\Services\Implementation\Validators\registeredUserValidator;


class RegisterFormValidationAggregate
{
    private array $validators;
    private User $user;
    private bool $isRegisteredUser;
    private string $action;

    public function __construct($dataToValidate, $fileToValidate, $action = 'register')
    {
        $this->user = new User();
        $this->isRegisteredUser = $this->user->isRegistered($dataToValidate['email']);
        $this->action = $action;

        $this->validators = [
            'name' => new NameValidator($dataToValidate['name']),
            'email' => new EmailValidator($dataToValidate['email']),
            'avatar' => new AvatarValidator($fileToValidate),
            'password' => new PasswordValidator($dataToValidate['password']),
            'passwordConfirmation' => new PasswordConfirmationValidator(
                $dataToValidate['password'],
                $dataToValidate['password_confirmation']
            ),
            'checkEmail' => new registeredUserValidator($this->isRegisteredUser, $this->action),
        ];
    }

    public function getValidationResult(): array
    {
        $errors = array_map(fn($validator) => $validator->validate(),
            $this->validators);

        return array_filter($errors, fn($errorMessage) => $errorMessage != "");
    }
}