<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 19:31
 */

namespace App\Response\Body;

interface BodyInterface
{
    public function toArray(): array;

    public function getMessage(): string;
}