<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\WWWAuthenticate;

use Innmind\Http\Header\Parameter;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Challenge
{
    private function __construct(
        private string $scheme,
        private string $realm,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    #[\NoDiscard]
    public static function maybe(string $scheme, string $realm): Maybe
    {
        $scheme = Str::of($scheme);

        if (!$scheme->matches('~^\w+$~')) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        return Maybe::just(new self($scheme->toString(), $realm));
    }

    #[\NoDiscard]
    public function scheme(): string
    {
        return $this->scheme;
    }

    #[\NoDiscard]
    public function realm(): string
    {
        return $this->realm;
    }

    #[\NoDiscard]
    public function toString(): string
    {
        return Str::of($this->scheme)
            ->append(' ')
            ->append((Parameter::of('realm', $this->realm))->toString())
            ->trim()
            ->toString();
    }
}
