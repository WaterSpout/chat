<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 19:05
 */

namespace App\Key;

interface KeyInterface
{
    public function getKey(): string;

    public function setKey(string $key): void;

    public static function generate(): string;

    public function regenerate(): bool;
}