<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\Referrer,
};
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class ReferrerFactory implements HeaderFactory
{
    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'referer') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        return Url::maybe($value->toString())->map(
            Referrer::of(...),
        );
    }
}
