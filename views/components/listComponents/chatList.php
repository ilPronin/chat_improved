<?php
session_start();
use App\Models\User;
use App\Services\Implementation\Helper;
$user = new User();
$chats = $user->getChat($_SESSION['user']['id']);
//print_r($chats);
?>
<div class="chatList">
    <?php if (!empty($chats)) { ?>
        <?php foreach ($chats as $chat) { ?>
        <div class="item">
            <img src="<?= $chat['avatar']?>" alt="">
            <div class="item__info">
                <span><?= $chat['name']?></span>
            </div>
            <?php if (Helper::last_seen($chat['last_seen']) == 'Онлайн') {?>
            <div>
                <div class="online"></div>
            </div>
            <?php } else {?>
            <div class="offline"><p><?= Helper::last_seen($chat['last_seen'])?></p></div>
        </div>
        <?php } }?>
    <?php } else {?>
        <h2 style="padding: 20px">У вас пока что нет сообщений</h2>
        <?php }?>

    <script>
        let lastSeenUpdate = function() {
            $.get(<?php $user->lastSeenUpdate($_SESSION['user']['id']);?>)
        }
        lastSeenUpdate();
        setInterval(lastSeenUpdate, 10000);
    </script>

</div>
