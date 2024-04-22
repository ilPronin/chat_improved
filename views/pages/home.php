<?php

use App\Services\Page;

?>

<!doctype html>
<html lang="en">
<?php
Page::addHead('HOME'); ?>
<body>
<div class="center">
    <h1>ЧАТ</h1>
    <p style="text-align: center">Войдите в свой аккаунт, чтобы пользоваться чатом :)</p>
    <a href="/login" class="link-button">ВОЙТИ</a>

</div>
</body>
</html>