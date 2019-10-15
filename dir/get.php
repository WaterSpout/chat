<?php
require_once '../vendor/autoload.php';
if (!\App\Response\ResponseHelper::isAjax()) {
    http_response_code(\App\Response\HttpStatus::HTTP_FORBIDDEN);
    echo 'Forbidden';
    exit;
}

$keyNumber = trim(strip_tags($_POST['keyNumber'] ?? ''));
$key = new \App\Key\Key();
$key->setKey($keyNumber);
$chat = new \App\Chat\Chat();
if (empty($keyNumber) || !$chat->isKeyValid($key)) {
    \App\Response\JsonResponse::responseError('Не валидный ключ');

    return;
}
$messages = $chat->get($key, $error);
$messagesFiltered = array_filter($messages, function (\App\Message\MessageInterface $message) use ($key) {
    return !$message->isReadable($key);
});
array_walk($messages, function (\App\Message\MessageInterface $message) use ($key) {
    $message->markReadable($key);
});
if (!empty($messagesFiltered)) {
    if (!$chat->saveMessages($messages)) {
        \App\Response\JsonResponse::responseError('Не удалось отметить сообщения');

        return;
    }
}
$response = new \App\Response\Body\GetMessageBody();
$response->setMessages($messagesFiltered);
\App\Response\JsonResponse::response($response, \App\Response\HttpStatus::HTTP_OK);