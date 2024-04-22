<?php

use App\Services\Page;

?>

<!doctype html>
<html lang="en">
<?php Page::addHead('REGISTRATION'); ?>
<body>
<div class="center">
    <form action="/auth/register" method="post" enctype="multipart/form-data">
        <h1 class="title">РЕГИСТРАЦИЯ</h1>

        <div class="form-group">
            <label for="name">Имя</label>
            <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder=""
                    value=""
                    required
            >
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input
                    type="text"
                    id="email"
                    name="email"
                    placeholder=""
                    value=""
                    required
            >
        </div>

        <div class="upload_file">
            <input type="file" id="avatar" name="avatar">
            <label class="input-file" for="avatar">Загрузите аватар</label>
        </div>

        <div class="password-group">
            <div class="form-group">
                <label for="email">Пароль</label>
                <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder=""
                        value=""
                        required
                >
            </div>
            <div class="form-group">
                <label for="email">Подтверждение пароля</label>
                <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder=""
                        value=""
                        required
                >
            </div>
        </div>

        <button type="submit" id="submit">
            ЗАРЕГИСТРИРОВАТЬСЯ
        </button>

        <div class="signup_link">
            <p>У меня уже есть <a href="/login">аккаунт</a></p>
        </div>
    </form>
</body>
</html>