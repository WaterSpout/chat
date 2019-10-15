<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 19:06
 */

namespace App\Key;

class Key implements KeyInterface
{

    /**
     * @var string
     */
    private $key;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public static function generate(): string
    {
        $string = '';

        while (($len = strlen($string)) < 15) {
            $size = 15 - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    public function regenerate(): bool
    {
        try {
            $key = self::generate();
            $this->setKey($key);

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}