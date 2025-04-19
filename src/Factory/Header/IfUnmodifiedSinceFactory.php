<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header,
    Header\IfUnmodifiedSince,
    TimeContinuum\Format\Http,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Validation\Is;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 */
final class IfUnmodifiedSinceFactory implements Implementation
{
    public function __construct(
        private Clock $clock,
    ) {
    }

    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'if-unmodified-since') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        return Is::string()->nonEmpty()($value->toString())
            ->maybe()
            ->flatMap(fn($value) => $this->clock->at($value, Http::new()))
            ->map(IfUnmodifiedSince::of(...));
    }
}
