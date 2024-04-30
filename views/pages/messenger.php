<?php
use App\Services\Implementation\Page;

session_start()
?>

<!doctype html>
<html lang="en">
<?php Page::addHead('MESSENGER');?>
<body>
<h1><?=$_SESSION['user']['id']?></h1>
</body>
</html>
