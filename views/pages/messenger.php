<?php
use App\Services\Implementation\Page;
use App\Services\Implementation\Router;
use App\Services\Implementation\Helper;


session_start();

Helper::checkAuth();

?>

<!doctype html>
<html lang="en">
<?php Page::addHead('MESSENGER');?>
<script src="/scripts/script.js"></script>
<body>
<div class="container">
    <?php
    Page::addComponent('list');
    Page::addComponent('chat');
    ?>
</div>
</body>
</html>
