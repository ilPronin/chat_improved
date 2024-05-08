<div class="messageForm">
    <form id="messageForm"">
        <div class="file">
            <label class="file_input">
                <input type="file" id="file" name="file">
                <img src="/assets/icons/paperclip.png" class="paperclip" alt="">
            </label>
        </div>
        <input type="text" placeholder="Сообщение..." id="inputMessage">
        <button class="sendButton" id="sendButton" type="submit">Отправить</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#messageForm').on('submit', function (e) {
            e.preventDefault();

            let message = $('#inputMessage').val();
            let formData = new FormData($(this)[0]);

            if (message === '') return;

            formData.append('message', message);

            $.ajax({
                url: '/messenger/sendMessage',
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,

                success: function (response) {
                    console.log(response)
                    // $('.messageDisplay').html(response);
                    $('#inputMessage').val('');
                }
            })
        })
        $('#messageForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '/messenger/renderMessages',
                method: 'post',

                success: function (response) {
                    console.log(response)
                    $('.messageDisplay').html(response);
                    $('#inputMessage').val('');
                }
            })
        })
    })
</script>
