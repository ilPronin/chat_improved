<?php

use App\Services\Implementation\Page;
use App\Services\Implementation\Helper;

session_start();
$errors = $_SESSION['validate'] ?? [];
?>

<!doctype html>
<html lang="en">
<?php Page::addHead('REGISTRATION'); ?>
    <body>
    <div class="center">
        <form action="/auth/register" method="post" enctype="multipart/form-data">
            <h1 class="title">РЕГИСТРАЦИЯ</h1>

            <div class="form-group">
                <div class="label-form-group">
                    <label for="name" class="form-label">Имя</label>
                    <?php
                    if (isset($errors['name'])) : ?>
                        <span class="error-message"><?= $errors['name'] ?></span>
                    <?php
                    endif; ?>
                </div>
                <input type="text" id="name" name="name" placeholder=""
                       value="<?= Helper::getOldValue('name') ?>" required>
            </div>

            <div class="form-group">
                <div class="label-form-group">
                    <label class="form-label" for="email">E-mail</label>
                    <?php
                        if (isset($errors['email']) || isset($errors['checkEmail'])) : ?>
                            <span class="error-message"><?= $errors['email'] ?? $errors['checkEmail'] ?></span>
                    <?php endif; ?>
                </div>
                <input type="text" id="email" name="email" placeholder=""
                       value="<?= Helper::getOldValue('email') ?>" required>
            </div>

            <div class="upload_file">
                <input type="file" id="avatar" name="avatar">
                <div class="label-form-group">
                    <label class="form-label input-file" for="avatar">Загрузите
                        аватар</label>
                    <?php
                    if (isset($errors['avatar'])) : ?>
                        <span class="error-message"><?= $errors['avatar'] ?></span>
                    <?php
                    endif; ?>
                </div>
            </div>

            <div class="password-group">
                <div class="form-group">
                    <div class="label-form-group">
                        <label for="email" class="form-label">Пароль</label>
                        <?php
                        if (isset($errors['password'])) : ?>
                            <span class="error-message"><?= $errors['password'] ?></span>
                        <?php
                        endif; ?>
                    </div>
                    <input type="password" id="password" name="password"
                           placeholder="" value="" required>
                </div>
                <div class="form-group">
                    <div class="label-form-group">
                        <label for="email" class="form-label">Подтверждение
                            пароля</label>
                        <?php
                        if (isset($errors['passwordConfirmation'])) : ?>
                            <span class="error-message"><?= $errors['passwordConfirmation'] ?></span>
                        <?php
                        endif; ?>
                    </div>
                    <input type="password" id="password_confirmation"
                           name="password_confirmation" placeholder="" value=""
                           required>
                </div>
            </div>

            <button type="submit" id="submit">
                ЗАРЕГИСТРИРОВАТЬСЯ
            </button>

            <div class="signup_link">
                <p>У меня уже есть <a href="/login">аккаунт</a></p>
            </div>
        </form>
        <?php
        session_destroy() ?>
    </body>
</html>