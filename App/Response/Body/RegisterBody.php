<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 19:33
 */

namespace App\Response\Body;

use App\Key\KeyInterface;

class RegisterBody implements BodyInterface
{

    /**
     * @var KeyInterface
     */
    private $key;

    public function toArray(): array
    {
        return [
            'key' => $this->getKey()->getKey(),
        ];
    }

    public function getMessage(): string
    {
        return 'Пользователь успешно зарегестрирован';
    }

    /**
     * @return KeyInterface
     */
    public function getKey(): KeyInterface
    {
        return $this->key;
    }

    /**
     * @param KeyInterface $key
     */
    public function setKey(KeyInterface $key): void
    {
        $this->key = $key;
    }
}