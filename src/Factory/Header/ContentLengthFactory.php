<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header\ContentLength,
    Header\ContentLengthValue,
    Header,
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
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'content-length') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        return Maybe::just($value->toString())
            ->filter(\is_numeric(...))
            ->map(static fn($length) => (int) $length)
            ->flatMap(ContentLengthValue::of(...))
            ->map(static fn($value) => new ContentLength($value));
    }
}
