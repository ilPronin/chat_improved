<?php
use App\Services\Implementation\Page;

session_start()
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