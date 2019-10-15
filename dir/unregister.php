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
$keyNumber = trim(strip_tags($_POST['keyNumberDeleting'] ?? ''));
$key = new \App\Key\Key;
$key->setKey($keyNumber);
$chat = new Chat();
if (empty($keyNumber) || !$chat->isKeyValid($key)) {
    header('Location: /?error=Такого ключа не существует&keyNumberDeleting=' . $key->getKey());
    exit;
}
$error = null;
$chat->unregister($key, $error);
if (!empty($error)) {
    header('Location: /?error=' . $error);
    exit;
}
header('Location: /?deleted=1');
