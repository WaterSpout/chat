<?php
include_once 'header.php';
?>
    <div class="row" style="margin-top: 20px;">
        <form action="chat.php">
            <div class="form-group">
                <label for="keyNumber">Ваш ключ</label>
                <input type="text" class="form-control" id="keyNumber" name="keyNumber" aria-describedby="keyNumber" placeholder="Ваш ключ" value="<?=$_GET['keyNumber'] ?? '';?>">
                <?php if (isset($_GET['keyNumber']) && !empty($_GET['keyNumber'])): ?>
                    <p>Вы успешно зарегистрировались, пожалуйста, сохраните ваш ключ: <?=$_GET['keyNumber'];?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Присоедениться к чату</button>
        </form>
    </div>
    <div class="row" style="margin-top: 20px;">
        <form method="post" action="/register.php">
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </form>
    </div>
    <hr>
    <div class="row" style="margin-top: 20px;">
        <form method="post" action="unregister.php">
            <div class="form-group">
                <label for="keyNumberDeleting">Ваш ключ</label>
                <input type="text" class="form-control" id="keyNumberDeleting" name="keyNumberDeleting" aria-describedby="keyNumberDeleting" placeholder="Ваш ключ" value="<?=$_GET['keyNumberDeleting'] ?? '';?>">
                <?php if ('1' == ($_GET['deleted'] ?? '')): ?>
                    <p>Вы успешно удалились</p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Удалить пользователя</button>
        </form>
    </div>
<?php
include_once 'footer.php';
?>