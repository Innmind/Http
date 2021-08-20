<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header\ContentLength,
    Header,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class ContentLengthFactory implements HeaderFactory
{
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'content-length') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Maybe<Header> */
        return Maybe::just(ContentLength::of((int) $value->toString()));
    }
}
