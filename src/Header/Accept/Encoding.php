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
final class Encoding
{
    private function __construct(
        private Str $coding,
        private Quality $quality,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(string $coding, ?Quality $quality = null): Maybe
    {
        $coding = Str::of($coding);

        if (
            $coding->toString() !== '*' &&
            !$coding->matches('~^\w+$~')
        ) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        return Maybe::just(new self($coding, $quality ?? Quality::max()));
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
            ->append($this->quality->toParameter()->toString())
            ->toString();
    }
}
