<?php

?>
namespace App\Services;

final class Validator
{
//    private string $name;
//    private string $email;
//    private ?array $avatar;
//    private string $password;
//    private string $passwordConfirmation;
//
//    public function __construct(
//        string $name,
//        string $email,
//        string $password,
//        string $passwordConfirmation,
//        array $avatar = null
//    ) {
//        $this->name = $name;
//        $this->email = $email;
//        $this->password = $password;
//        $this->passwordConfirmation = $passwordConfirmation;
//        $this->avatar = $avatar;
//    }
//
//    public function getValidationErrors(): array
//    {
//        $possibleErrors = array_merge(
//            $this->setPossibleError('name', $this->validateName()),
//            $this->setPossibleError('email', $this->validateEmail()),
//            $this->setPossibleError('password', $this->validatePassword()),
//            $this->setPossibleError('passwordConfirmation', $this->validatePasswordConfirmation()),
//            $this->setPossibleError('avatar', $this->validateProfilePhoto())
//        );
//
//        $currentErrors = [];
//
//        foreach ($possibleErrors as $key => $error) {
//            if (!empty($error)) {
//                $currentErrors[$key] = $error;
//            }
//        }
//        return $currentErrors;
//    }
//
//    private function setPossibleError($key, $error): array
//    {
//        return [$key => $error];
//    }
//
//    private function validateName(): string
//    {
//        if (empty($this->name) || preg_match('/[^A-Za-z0-9\s]/', $this->name)) {
//            return "Неверный формат имени";
//        }
//        return '';
//    }
//
//    private function validateEmail(): string
//    {
//        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
//            return "Некорректная почта";
//        }
//        return "";
//    }
//
//    private function validatePassword(): string
//    {
//        if (empty($this->password)) {
//            return "Введите пароль";
//        }
//        return "";
//    }
//
//    private function validatePasswordConfirmation(): string
//    {
//        if ($this->password !== $this->passwordConfirmation) {
//            return "Пароли не совпадают";
//        }
//        return "";
//    }
//
//    private function validateProfilePhoto(): string
//    {
//        if (!empty($this->avatar) && $this->avatar['error'] == 0) {
//            $typesOfImage = ['image/jpeg', 'image/png'];
//            return in_array($this->avatar['type'], $typesOfImage) ? ''
//                : "Изображение имеет неверный тип";
//        }
//        return "";
//    }

    public function validateData(array $data, array $files): array
    {
        $errors = [];
        $typesOfImage = ['image/jpeg', 'image/png'];

        $name = htmlspecialchars(trim($data['name']));
        $email = htmlspecialchars($data['email']);
        $avatar = isset($files['avatar'])
        && $files['avatar']['error'] === UPLOAD_ERR_OK ? $files['avatar']
            : null;
        $password = htmlspecialchars(trim($data['password']));
        $passwordConfirmation = htmlspecialchars($data['password_confirmation']);


        // Валидация имени
        if (empty($name)){
            $errors['name'] = 'Имя не должно быть пустым';
        } elseif (!preg_match('/[^A-Za-z0-9\s]/', $name)) {
            $errors['name'] = 'Имя может содержать только латинские буквы, цифры и пробелы.';
        }

        // Валидация электронной почты
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Некорректный адрес электронной почты.';
        }

        // Валидация пароля
        if ($password != trim($password)){
            $errors['password'] = 'Пароль не должен содержать начинаться и заканчиваться пробелами';
        } elseif (strlen($password) < 6 || strlen($password) > 128) {
            $errors['password'] = 'Пароль должен быть длиной от 6 до 128 символов.';
        }

        // Валидация подтверждения пароля
        if ($password !== $passwordConfirmation) {
            $errors['password'] = 'Пароли не совпадают.';
        }

        // Валидация аватара
        if ($avatar !== null && !is_uploaded_file($avatar['tmp_name'])) {
            $errors['avatar'] = 'Произошла ошибка при загрузке аватара.';
        } elseif (!in_array($avatar['type'], $typesOfImage)){
            $errors['avatar'] = "Изображение имеет неверный тип";
        }

        return $errors;
    }
}