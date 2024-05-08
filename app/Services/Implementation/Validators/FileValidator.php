<?php

namespace App\Services\Implementation\Validators;
use App\Services\Interfaces\IValidator;

class FileValidator implements IValidator
{
    private ?array $file;
    private array $typesOfImage = ['image/jpeg', 'image/png', 'image/gif'];
    private array $typesOfDoc = ['text/plain'];


    public function __construct($file)
    {
        $this->file = $file;
    }

    public function validate(): string
    {
        if ($this->file === null) return "";
        if (in_array($this->file['type'], $this->typesOfImage)) {
            $image_info = getimagesize($this->file["tmp_name"]);
            $image_width = $image_info[0];
            $image_height = $image_info[1];
            if ($image_height > 1080 || $image_width > 1920){
                return "Размер картинки слишком большой";
            } else {
//              TODO! $filePath = ;
            }
        } elseif (in_array($this->file['type'], $this->typesOfDoc) && $this->file['size'] < 80000){
//              TODO! $filePath = ;
        } else{
            return  "Файл имеет неверный формат, либо слишком большой";
        }
        return "";
    }
}