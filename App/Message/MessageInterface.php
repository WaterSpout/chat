<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 18:58
 */

namespace App\Message;

use App\Key\KeyInterface;

interface MessageInterface
{
    public function isReadable(KeyInterface $key): bool;

    public function markReadable(KeyInterface $key): void;

    public function getText(): string;

    public function getNickName(): string;
}