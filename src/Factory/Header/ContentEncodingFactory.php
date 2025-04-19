<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header,
    Header\ContentEncoding,
    Header\ContentEncodingValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 */
final class ContentEncodingFactory implements Implementation
{
    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'content-encoding') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        return ContentEncodingValue::of($value->toString())->map(
            static fn($value) => new ContentEncoding($value),
        );
    }
}
