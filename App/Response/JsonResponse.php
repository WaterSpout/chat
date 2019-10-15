<?php

namespace App\Response;

use App\Response\Body\BodyInterface;
use App\Response\Body\ErrorBody;

class JsonResponse implements ResponseInterface
{

    /**
     * @param BodyInterface $body
     * @param int $status
     */
    public static function response(BodyInterface $body, int $status): void
    {
        HttpStatus::isInvalid($status) ?: $status = HttpStatus::HTTP_UNPROCESSABLE_ENTITY;
        $response = [
            'body'    => $body->toArray(),
            'status'  => $status,
            'message' => $body->getMessage(),
        ];
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    public static function responseError(string $error, int $status = HttpStatus::HTTP_UNPROCESSABLE_ENTITY): void
    {
        $error = new ErrorBody;
        $error->setError($error);
        self::response($error, $status);
    }
}
