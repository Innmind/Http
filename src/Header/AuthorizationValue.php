<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

/**
 * @psalm-immutable
 */
final class AuthorizationValue extends Value\Value
{
    private string $scheme;
    private string $parameter;

    public function __construct(string $scheme, string $parameter)
    {
        $scheme = Str::of($scheme);

        if (!$scheme->matches('~^\w+$~')) {
            throw new DomainException($scheme->toString());
        }

        $this->scheme = $scheme->toString();
        $this->parameter = $parameter;
        parent::__construct(
            $scheme
                ->prepend('"')
                ->append('" ')
                ->append($parameter)
                ->trim()
                ->toString(),
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
