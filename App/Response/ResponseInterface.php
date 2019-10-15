<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 19:18
 */

namespace App\Response;

use App\Response\Body\BodyInterface;

interface ResponseInterface
{
    public static function response(BodyInterface $body, int $status): void;

    public static function responseError(string $error, int $status = HttpStatus::HTTP_UNPROCESSABLE_ENTITY): void;
}