<?php

namespace App\Services\Aggregates;

use App\Models\User;

use App\Services\Implementation\Validators\FileValidator;

class FileValidationAggregate
{
    private array $validators;

    public function __construct($file)
    {
        $this->user = new User();

        $this->validators = [
            'file' => new FileValidator($file),
        ];
    }

    public function getValidationResult(): array
    {
        $errors = array_map(fn($validator) => $validator->validate(),
            $this->validators);

        return array_filter($errors, fn($errorMessage) => $errorMessage != "");
    }
}