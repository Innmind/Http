<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header\ContentLength,
    Header\ContentLengthValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 */
final class ContentLengthFactory implements Implementation
{
    #[\Override]
    public function __invoke(Str $value): Maybe
    {
        return Maybe::just($value->toString())
            ->filter(\is_numeric(...))
            ->map(static fn($length) => (int) $length)
            ->flatMap(ContentLengthValue::of(...))
            ->map(static fn($value) => new ContentLength($value));
    }
}
