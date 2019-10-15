<?php
include_once 'header.php';
$keyNumber = trim(strip_tags($_GET['keyNumber'] ?? ''));
if (empty($keyNumber)) {
    header('Location: /?error=ключ не найден');
    exit;
}
$key = new \App\Key\Key();
$key->setKey($keyNumber);
$chat = new \App\Chat\Chat();
if (!$chat->isKeyValid($key)) {
    header('Location: /?error=не валидный ключ');
    exit;
}
$error = null;
$messages = $chat->get($key, $error);
// print_r(end($messages));exit;
if (!empty($error)) {
    header('Location: /?error=Произошла ошибка, попробуйсте переподключится&keyNumber=' . $key->getKey());
    exit;
}
/**
 * @var \App\Message\MessageInterface $message
 */
?>
    <div class="block template" style="display: none;">
        <div class="row" style="margin-top: 20px;">
            <div class=".col-lg-12">
                Автор: <span class="author"></span>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class=".col-lg-12 text"></div>
        </div>
        <hr>
    </div>
    <div id="chat">
        <?php if (empty($messages)): ?>
            <p id="no_mess">Нет сообщений</p>
        <?php else: ?>
            <?php foreach ($messages as $i => $message): ?>
                <div class="block">
                    <div class="row" style="margin-top: 20px;">
                        <div class=".col-lg-12">
                            Автор: <span class="author"><?=$message->getNickName();?></span>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class=".col-lg-12 text">
                            <?=$message->getText();?>
                        </div>
                    </div>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="row" style="margin-top: 20px;">
        <form method="post" action="/add.php">
            <div class="form-group">
                <label for="nick">Ник</label>
                <input type="text" class="form-control" id="nick" name="nick" aria-describedby="nick" placeholder="Ваш ник" value="<?=$_GET['nick'] ?? '';?>">
            </div>
            <div class="form-group">
                <label for="textA">Текст</label>
                <textarea class="form-control" name="text" id="textA"><?=$_GET['text'] ?? '';?></textarea>
            </div>
            <input type="hidden" name="keyNumber" value="<?=$key->getKey();?>">
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
    </div>
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            let timerId = setTimeout(function getMessage() {
                let data = {'keyNumber': '<?=$key->getKey();?>'};
                $.ajax({
                    type: "POST",
                    url: '/get.php',
                    data: data,
                    success: success,
                    dataType: 'json'
                });
                timerId = setTimeout(getMessage, 3000);
            }, 3000);

            function success(data) {
                if (Object.keys(data.body.messages).length > 0) {
                    $('#no_mess').remove();
                    let chat = $('#chat');
                    $.each(data.body.messages, function (key, message) {
                        let row;
                        row = $('.template').clone();
                        row.find('.author').text(message.nickName);
                        row.find('.text').text(message.text);
                        chat.append(row);
                        row.show();
                    });
                }
            }
        });
    </script>
<?php
include_once 'footer.php';
?>