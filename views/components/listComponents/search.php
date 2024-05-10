<?php

session_start();

use App\Models\User;
use App\Controllers\Messenger;

$user = new User();
$messenger = new Messenger();
?>
<div class="search">
    <div class="searchBar">
        <img src="/assets/icons/search.png" alt="search">
        <input type="text" placeholder="Поиск" id="searchText">
    </div>
    <img src="/assets/icons/plus.png" alt="add" class="add" id="toggleImage"
         onclick="toggleImage()">
</div>

<script>
    $(document).ready(function () {
        $("#searchText").on("input", function () {
            let searchText = $(this).val();

            $.post('/messenger/search',
                {
                    key: searchText
                },
                function (data, status) {
                    $(".chatList").html(data);
                }
            );
        });
    })
</script>