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
final class AcceptEncodingValue implements Value
{
    private Str $coding;
    private Quality $quality;

    public function __construct(string $coding, ?Quality $quality = null)
    {
        $coding = Str::of($coding);
        $quality = $quality ?? new Quality(1);

        if (
            $coding->toString() !== '*' &&
            !$coding->matches('~^\w+$~')
        ) {
            throw new DomainException($coding->toString());
        }

        $this->coding = $coding;
        $this->quality = $quality;
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(string $coding, ?Quality $quality = null): Maybe
    {
        try {
            return Maybe::just(new self($coding, $quality));
        } catch (DomainException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
    }

    public function quality(): Quality
    {
        return $this->quality;
    }

    public function toString(): string
    {
        return $this
            ->coding
            ->append(';')
            ->append($this->quality->toString())
            ->toString();
    }
}
