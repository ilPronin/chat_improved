<?php

session_start();

use App\Models\User;
use App\Models\Chat;
use App\Services\Implementation\Helper;

$user = new User();
$chat = new Chat();

$chats = $user->getChat($_SESSION['user']['id']);
//print_r($chats);
?>
<div class="chatList">
    <?php if (!empty($chats)) { ?>
        <?php foreach ($chats as $chat) { ?>
        <div class="item" data-id="<?=$chat['id']?>">
            <img src="<?= $chat['avatar']?>" alt="">
            <div class="item__info">
                <span><?= $chat['name']?></span>
            </div>
            <?php if (Helper::last_seen($chat['last_seen']) == 'Онлайн') {?>
                <div class="online"></div>
            <?php } else {?>
            <div class="offline"><p><?= Helper::last_seen($chat['last_seen'])?></p></div>
                <?php }?>
        </div>
        <?php }?>
    <?php } else {?>
        <h2 style="padding: 20px">У вас пока что нет сообщений</h2>
        <?php }?>

    <script>
        let lastSeenUpdate = function() {
            $.get(<?php $user->lastSeenUpdate($_SESSION['user']['id']);?>)
        }
        lastSeenUpdate();
        setInterval(lastSeenUpdate, 10000);

        $('.item').on('click', function (){
            let userId = $(this).data('id');
            $.ajax({
                url: '/messenger/renderUserToTalk',
                type: 'POST',
                data: {userId: userId},
                success: function (data) {
                    $('.currentUserProfile').html(data);
                }
            })
        });

        $('.item').on('click', function (){
            let userId = $(this).data('id');
            $.ajax({
                url: '/messenger/renderMessages',
                type: 'POST',
                data: {userId: userId},
                success: function (data) {
                    $('.messageDisplay').html(data);
                }
            })
        })

    </script>

</div>
