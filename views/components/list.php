<?php use App\Services\Implementation\Page; ?>
<div class="list">
    <?php
    Page::addComponent('/listComponents/userInfo');
    Page::addComponent('/listComponents/search');
    Page::addComponent('/listComponents/chatList');
    ?>
</div>
