<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 19:00
 */

namespace App\Message;

use App\Key\KeyInterface;

class Message implements MessageInterface
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $nickName;

    /**
     * @var []string
     */
    private $keys = [];

    public function __construct(string $text, string $nickName)
    {
        $this->text = $text;
        $this->nickName = $nickName;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getNickName(): string
    {
        return $this->nickName;
    }

    public function isReadable(KeyInterface $key): bool
    {
        return in_array($key->getKey(), $this->keys);
    }

    public function markReadable(KeyInterface $key): void
    {
        if (!$this->isReadable($key)) {
            $this->keys[] = $key->getKey();
        }
    }
}