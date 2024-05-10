<?php
use App\Services\Implementation\Page;
use App\Services\Implementation\Helper;


session_start();

Helper::checkAuth();

?>
<!doctype html>
<html lang="en">
<?php Page::addHead('MESSENGER');?>
<script src="/scripts/script.js"></script>
<body>
<div class="pageNotFound">
   <h1>404 - страница не найдена</h1>
</div>
</body>
</html>