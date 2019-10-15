<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 18:55
 */

namespace App\Chat;

use App\Key\Key;
use App\Key\KeyInterface;
use App\Message\MessageInterface;

class Chat implements ChatInterface
{

    /**
     * @var \Memcached
     */
    private $memcached;

    public function __construct()
    {
        $memcached = new \Memcached();
        $memcached->addServer("127.0.0.1", 11211);
        $this->memcached = $memcached;
    }

    public function register(&$error = null): ?KeyInterface
    {
        $key = new Key();
        try {
            $key->setKey(Key::generate());
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
        }
        if (!is_null($error)) {
            return null;
        }
        if (!$this->memcached->add($key->getKey(), true)) {
            $cnt = 0;
            while (!$key->regenerate()) {
                if ($cnt > 10) {
                    $error = 'Не удается сгенерировать ключ';

                    return null;
                }
                $cnt++;
            }
        }
        $this->memcached->add($key->getKey(), true);

        return $key;
    }

    public function unregister(KeyInterface $key, ?string &$error = null): void
    {
        if (!$this->memcached->delete($key->getKey())) {
            $error = 'Не удалось удалить пользователя';
        }
    }

    public function write(MessageInterface $message, ?string &$error = null): void
    {
        $messages = $this->memcached->get('messages');
        if (empty($messages)) {
            $messages = [];
        }
        $messages[] = $message;
        if (!$this->saveMessages($messages)) {
            $error = 'Не удалось добавить сообщение';
        }
    }

    public function get(KeyInterface $key, ?string &$error = null): array
    {
        $messages = $this->memcached->get('messages');
        if (empty($messages)) {
            $messages = [];
        }

        return $messages;
    }

    public function isKeyValid(KeyInterface $key): bool
    {
        return $this->memcached->get($key->getKey());
    }

    public function saveMessages(array $messages): bool
    {
        return $this->memcached->set('messages', $messages);
    }
}