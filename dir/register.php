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
$chat = new Chat();
$error = null;
$key = $chat->register($error);
if (is_null($key)) {
    header('Location: /?error=' . $error);
    exit;
}
header('Location: /?keyNumber=' . $key->getKey());
