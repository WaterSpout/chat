<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 14.10.19
 * Time: 19:35
 */

namespace App\Response\Body;

class ErrorBody implements BodyInterface
{
    /**
     * @var string
     */
    private $error;

    public function toArray(): array
    {
        return [
            'error' => $this->getError(),
        ];
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError(string $error): void
    {
        $this->error = $error;
    }

    public function getMessage(): string
    {
        return 'Что-то пошло не так';
    }
}