<?php

use App\Services\Page;

?>

<!doctype html>
<html lang="en">
<?php
Page::addHead('LOGIN'); ?>
<body>
<div class="center">
    <form action="">
        <h1 class="title">АВТОРИЗАЦИЯ</h1>

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

        <button type="submit" id="submit">
            ВОЙТИ
        </button>

        <div class="signup_link">
            <p>У меня еще нет <a href="/register">аккаунта</a></p>
        </div>
    </form>
</div>
</body>
</html>