<?php require_once '../vendor/autoload.php';

use \App\Response\HttpStatus;
use \App\Chat\Chat;

/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 22:06
 */
if ('POST' !== $_SERVER['REQUEST_METHOD']) {
    http_response_code(HttpStatus::HTTP_FORBIDDEN);
    echo 'Forbidden';
    exit;
}
$nick = trim(strip_tags($_POST['nick'] ?? ''));
$text = trim(strip_tags($_POST['text'] ?? ''));
$keyNumber = trim(strip_tags($_POST['keyNumber'] ?? ''));
$error = '';
if (empty($nick) || mb_strlen($nick) > 50) {
    $error .= 'Ник должен быть указан и не превышать 50 символов' . '<br/>';
}
if (empty($text) || mb_strlen($text) > 500) {
    $error .= 'Текст должен быть указан и не превышать 500 символов' . '<br/>';
}
$key = new \App\Key\Key();
$key->setKey($keyNumber);
$chat = new Chat();
if (empty($keyNumber) || !$chat->isKeyValid($key)) {
    $error .= 'Не валидный ключ' . '<br/>';
}
$query = [
    'error'     => $error,
    'nick'      => $nick,
    'text'      => $text,
    'keyNumber' => $key->getKey(),
];
if (!empty($error)) {
    header('Location: /chat.php?' . http_build_query($query));
}
$message = new \App\Message\Message($text, $nick);
$message->markReadable($key);
$error = null;
$chat->write($message, $error);
if (is_null($key)) {
    header('Location: /chat.php?' . http_build_query($query));
    exit;
}
header('Location: /chat.php??keyNumber=' . $key->getKey());
