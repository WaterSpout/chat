<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 19:33
 */

namespace App\Response\Body;

use App\Message\MessageInterface;

class GetMessageBody implements BodyInterface
{
    /**
     * @var []MessageInterface
     */
    private $messages;

    public function toArray(): array
    {
        return [
            'messages' => array_map(function (MessageInterface $message) {
                return ['nickName' => $message->getNickName(), 'text' => $message->getText()];
            }, $this->messages),
        ];
    }

    public function getMessage(): string
    {
        return 'Сообщения получены';
    }

    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param array $messages
     */
    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }
}