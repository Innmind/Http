<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header\ContentLength,
    Header\ContentLengthValue,
    Header,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class ContentLengthFactory implements HeaderFactory
{
    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'content-length') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Maybe<Header> */
        return Maybe::just($value->toString())
            ->filter(static fn($length) => \is_numeric($length))
            ->map(static fn($length) => (int) $length)
            ->flatMap(static fn($length) => ContentLengthValue::of($length))
            ->map(static fn($value) => new ContentLength($value));
    }
}
