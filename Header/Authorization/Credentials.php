<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Authorization;

use Innmind\Http\Exception\InvalidArgumentException;

final class Credentials
{
    private $scheme;
    private $parameter;

    public function __construct(string $scheme, string $parameter)
    {
        if (empty($scheme)) {
            throw new InvalidArgumentException;
        }

        $this->scheme = $scheme;
        $this->parameter = $parameter;
    }

    public function scheme(): string
    {
        return $this->scheme;
    }

    public function parameter(): string
    {
        return $this->parameter;
    }
}
