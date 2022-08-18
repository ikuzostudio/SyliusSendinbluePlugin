<?php

namespace Ikuzo\SyliusSendinbluePlugin\Message;

class SendContactToSendinblue
{
    private $customerId;
    private $method;

    public function __construct(int $customerId, string $method)
    {
        $this->customerId = $customerId;
        $this->method = $method;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}