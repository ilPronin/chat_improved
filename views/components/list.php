<?php use App\Services\Implementation\Page; ?>
<script src="/scripts/jquery-3.7.1.js"></script>
<div class="list">
    <?php
    Page::addComponent('/listComponents/userInfo');
    Page::addComponent('/listComponents/search');
    Page::addComponent('/listComponents/chatList');
    Page::addComponent('addUser');
    ?>
</div>
