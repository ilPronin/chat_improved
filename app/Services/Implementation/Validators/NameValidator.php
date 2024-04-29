<?php

namespace App\Services\Implementation\Validators;

use App\Services\Interfaces\IValidator;

class NameValidator implements IValidator
{
    private string $name;

    public function __construct($name)
    {
        $this->name = htmlspecialchars($name);
    }

    public function validate(): string
    {
        if (empty($this->name)){
            return 'Имя не должно быть пустым';
        } elseif ($this->name !== trim($this->name)){
            return 'Имя не должно начинаться и/или заканчиваться пробелом';
        } elseif (preg_match('/[^A-Za-z0-9\s]/', $this->name)){
            return 'Имя может содержать только латинские буквы, цифры и пробелы.';
        }

        return "";
    }
}