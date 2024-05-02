<?php use App\Services\Implementation\Page; ?>
<div class="chat">
    <?php
    Page::addComponent('/chatComponents/currentUserProfile');
    Page::addComponent('/chatComponents/messageDisplay');
    Page::addComponent('/chatComponents/messageForm');
    ?>
</div>
