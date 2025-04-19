<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
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
    public function __invoke(Str $value): Maybe
    {
        return ContentEncodingValue::of($value->toString())->map(
            static fn($value) => new ContentEncoding($value),
        );
    }
}
