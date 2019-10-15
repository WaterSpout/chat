<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 19:33
 */

namespace App\Response\Body;

class WriteMessageBody implements BodyInterface
{

    public function toArray(): array
    {
        return [];
    }

    public function getMessage(): string
    {
        return 'Сообщение добавлено';
    }
}