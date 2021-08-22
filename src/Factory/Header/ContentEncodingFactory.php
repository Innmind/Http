<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\ContentEncoding,
    Header\ContentEncodingValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class ContentEncodingFactory implements HeaderFactory
{
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'content-encoding') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Maybe<Header> */
        return ContentEncodingValue::of($value->toString())->map(
            static fn($value) => new ContentEncoding($value),
        );
    }
}
