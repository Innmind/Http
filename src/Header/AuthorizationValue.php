<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

final class AuthorizationValue extends HeaderValue\HeaderValue
{
    private $scheme;
    private $parameter;

    public function __construct(string $scheme, string $parameter)
    {
        $scheme = new Str($scheme);

        if (!$scheme->matches('~^\w+$~')) {
            throw new DomainException;
        }

        $this->scheme = (string) $scheme;
        $this->parameter = $parameter;
        parent::__construct(
            (string) $scheme
                ->prepend('"')
                ->append('" ')
                ->append($parameter)
                ->trim()
        );
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
