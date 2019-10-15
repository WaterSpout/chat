<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 18:52
 */

namespace App\Chat;

use App\Key\KeyInterface;
use App\Message\MessageInterface;

interface ChatInterface
{
    public function register(&$error = null): ?KeyInterface;

    public function unregister(KeyInterface $key, ?string &$error = null): void;

    public function write(MessageInterface $message, ?string &$error = null): void;

    public function get(KeyInterface $key, ?string &$error = null): array;

    public function isKeyValid(KeyInterface $key): bool;

    public function saveMessages(array $messages): bool;
}