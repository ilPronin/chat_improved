<?php

namespace App\Services\Implementation\Validators;

use App\Services\Interfaces\IValidator;

class registeredUserValidator implements IValidator
{
    private string $isRegistered;
    private string $action;

    public function __construct($isRegistered, $action)
    {
        $this->isRegistered = $isRegistered;
        $this->action = $action;
    }


    public function validate(): string
    {
        if ($this->isRegistered && $this->action === 'register'){
            return 'Пользователь с таким E-mail уже зарегистрирован';
        } elseif (!$this->isRegistered && $this->action === 'login'){
            return 'Пользователь с таким E-mail еще не зарегистрирован';
        } else{
            return '';
        }
    }
}