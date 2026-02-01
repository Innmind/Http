<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Accept;

use Innmind\Http\Header\Parameter\Quality;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Charset
{
    private function __construct(
        private Str $charset,
        private Quality $quality,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    #[\NoDiscard]
    public static function maybe(string $charset, ?Quality $quality = null): Maybe
    {
        $charset = Str::of($charset);

        if (
            $charset->toString() !== '*' &&
            !$charset->matches('~^[a-zA-Z0-9\-_:\(\)]+$~')
        ) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        return Maybe::just(new self($charset, $quality ?? Quality::max()));
    }

    #[\NoDiscard]
    public function quality(): Quality
    {
        return $this->quality;
    }

    #[\NoDiscard]
    public function toString(): string
    {
        return $this
            ->charset
            ->append(';')
            ->append($this->quality->toParameter()->toString())
            ->toString();
    }
}
