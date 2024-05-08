function toggleImage(){
    let image = document.getElementById('toggleImage');
    let addUserComponent = document.getElementById('addUserComponent');

    if (image.src === 'http://chatoop/assets/icons/plus.png'){
        image.src = '/assets/icons/minus.png';
        addUserComponent.classList.remove('hidden');
    } else if (image.src === 'http://chatoop/assets/icons/minus.png'){
        image.src = '/assets/icons/plus.png';
        addUserComponent.classList.add('hidden');
    }
};

let onSearchInputChange = function () {
        $("#searchUser").on("input", function () {
            let searchUser = $(this).val();

            $.post('/messenger/searchNewUser',
                {
                    key: searchUser
                },
                function (data){
                    const users = $(data).toArray();
                    users.forEach((u) => {
                        const user = $(u);
                        const userId = user.find('input[name=userId]').val();
                        user.find('.add-user-button').on('click', { userId }, onSearchAddButtonClick);
                    });
                    $(".userList").html(users);
                }
            );
        });
};

let onSearchAddButtonClick = (e) => {
    console.log(e.data.userId);
    let userId  = e.data.userId;

    $.ajax({
        url: '/messenger/addNewUser',
        method : 'post',
        data: { userId },
        success: function (){
            console.log("success")
        }
    })
};

// const searchButton = $(".search-button");
// const searchForm = $(".searchNewUser");

// searchForm.on('submit', (e) => e.preventDefault());
// searchButton.on('click', (e) => onSearchButtonClick(e));

