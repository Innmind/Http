<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\IfModifiedSince,
    TimeContinuum\Format\Http,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Validation\Is;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class IfModifiedSinceFactory implements HeaderFactory
{
    private Clock $clock;

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;
    }

    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'if-modified-since') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        return Is::string()->nonEmpty()($value->toString())
            ->maybe()
            ->flatMap(fn($value) => $this->clock->at($value, Http::new()))
            ->map(static fn($point) => IfModifiedSince::of($point));
    }
}
