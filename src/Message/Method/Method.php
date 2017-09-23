<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Method;

use Innmind\Http\{
    Message\Method as MethodInterface,
    Exception\DomainException
};

final class Method implements MethodInterface
{
    private $method;

    public function __construct(string $method)
    {
        if (!defined('self::'.$method)) {
            throw new DomainException;
        }

        $this->method = $method;
    }

    public function __toString(): string
    {
        return $this->method;
    }
}
