<div class="messageForm">
    <form action="/messenger/sendMessage" method="post" enctype="multipart/form-data">
        <div class="file">
            <label class="input-file">
                <input type="file" id="file" name="file">
                <img src="/assets/icons/paperclip.png" class="paperclip" alt="">
            </label>
        </div>
        <input type="text" placeholder="Сообщение...">
        <button class="sendButton">Отправить</button>
    </form>
</div>

