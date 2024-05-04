<?php
session_start();
use App\Models\User;
use App\Services\Implementation\Page;
$user = new User();
?>
<div class="search">
    <div class="searchBar">
        <img src="/assets/icons/search.png" alt="search">
        <input type="text" placeholder="Поиск" id="searchText">
    </div>
    <img src="/assets/icons/plus.png" alt="add" class="add" id="toggleImage" onclick="toggleImage()">
</div>

<script>
    // const {log} = console;
    // const searchInput = document.querySelector('#searchText');
    //
    // const setDataToServer = async (value) => {
    //     const DATA = {searchText:value};
    //
    //     const responsve = await fetch('',{
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json;charset=utf-8'
    //         },
    //         body: JSON.stringify(DATA)
    //     });
    //
    //
    //     console.log(responsve);
    // }
    // log(location.pathname)
    // const getInputValue = (event) =>{
    //     const input = event.currentTarget;
    //     const inputData = input.value;
    //     setDataToServer(inputData);
    // };
    // searchInput.addEventListener('input',getInputValue)
    $(document).ready(function (){
        $("#searchText").on("input", function () {
            let searchText = $(this).val();

            $.post(<?php ?>,
                {
                    key: searchText
                },
                function (data, status){
                    $(".chatList").html(data);
                }
            );
        });
    })
</script>