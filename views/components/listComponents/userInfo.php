<?php
    session_start();
    use App\Models\User;
    if(isset($_SESSION['user']['id'])){
        $user = new User();
        $currentUser = $user->getCurrentUser($_SESSION['user']['id']);
    }
?>

<div class="userData">
    <div class="user">
        <img src="<?= $currentUser['avatar'] ?>" alt="default-avatar">
        <div class="userInfo">
            <h2><?= $currentUser['name']?></h2>
            <p><?= $currentUser['email']?></p>
        </div>
    </div>
    <img src="/assets/icons/exit.png" alt="exit" class="exit" id="exit">
</div>

<script>
    $(document).ready(function () {
        $('#exit').on('click', function (e) {
            $.ajax({
                url: '/messenger/logout',
                method: 'post',

                success: function () {
                    location.reload();
                }
            })
        })
    })
</script>