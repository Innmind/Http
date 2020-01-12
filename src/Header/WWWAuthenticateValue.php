<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

final class WWWAuthenticateValue extends Value\Value
{
    private string $scheme;
    private string $realm;

    public function __construct(string $scheme, string $realm)
    {
        $scheme = new Str($scheme);

        if (!$scheme->matches('~^\w+$~')) {
            throw new DomainException;
        }

        $this->scheme = (string) $scheme;
        $this->realm = $realm;
        parent::__construct(
            (string) $scheme
                ->append(' ')
                ->append((new Parameter\Parameter('realm', $realm))->toString())
                ->trim()
        );
    }

    public function scheme(): string
    {
        return $this->scheme;
    }

    public function realm(): string
    {
        return $this->realm;
    }
}
