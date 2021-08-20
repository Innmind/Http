<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\LastModified,
    TimeContinuum\Format\Http,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class LastModifiedFactory implements HeaderFactory
{
    private Clock $clock;

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;
    }

    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'last-modified') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Maybe<Header> */
        return $this
            ->clock
            ->at($value->toString(), new Http)
            ->map(static fn($point) => LastModified::of($point));
    }
}
