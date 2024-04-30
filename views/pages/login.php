<?php

use App\Services\Implementation\Page;
use App\Services\Implementation\Helper;

session_start();
$errors = $_SESSION['validate'] ?? [];
?>

<!doctype html>
<html lang="en">
<?php Page::addHead('LOGIN'); ?>
<body>
<div class="center">
    <form action="/auth/login" method="post">
        <h1 class="title">АВТОРИЗАЦИЯ</h1>

        <div class="form-group">
            <div class="label-form-group">
                <label class="form-label" for="email">E-mail</label>
                <?php
                if (isset($errors['email']) || isset($errors['checkEmail'])) : ?>
                    <span class="error-message"><?= $errors['email'] ?? $errors['checkEmail']?></span>
                <?php
                endif; ?>
            </div>
            <input type="text" id="email" name="email" placeholder=""
                   value="<?= Helper::getOldValue('email') ?>" required>
        </div>

        <div class="form-group">
            <div class="label-form-group">
                <label for="email" class="form-label">Пароль</label>
            </div>
            <input type="password" id="password" name="password"
                   placeholder="" value="" required>
        </div>


        <button type="submit" id="submit">
            ВОЙТИ
        </button>

        <div class="signup_link">
            <p>У меня еще нет <a href="/register">аккаунта</a></p>
        </div>
    </form>
    <?php
    session_destroy() ?>
</body>
</html>