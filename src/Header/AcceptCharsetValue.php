<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header\Parameter\Quality,
    Exception\DomainException,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class AcceptCharsetValue implements Value
{
    private Str $charset;
    private Quality $quality;

    public function __construct(string $charset, ?Quality $quality = null)
    {
        $charset = Str::of($charset);
        $quality = $quality ?? new Quality(1);

        if (
            $charset->toString() !== '*' &&
            !$charset->matches('~^[a-zA-Z0-9\-_:\(\)]+$~')
        ) {
            throw new DomainException($charset->toString());
        }

        $this->charset = $charset;
        $this->quality = $quality;
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(string $charset, ?Quality $quality = null): Maybe
    {
        try {
            return Maybe::just(new self($charset, $quality));
        } catch (DomainException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
    }

    public function quality(): Quality
    {
        return $this->quality;
    }

    #[\Override]
    public function toString(): string
    {
        return $this
            ->charset
            ->append(';')
            ->append($this->quality->toString())
            ->toString();
    }
}
