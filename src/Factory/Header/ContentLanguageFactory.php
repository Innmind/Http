<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header\ContentLanguage,
    Header\ContentLanguageValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
    Sequence,
};

/**
 * @internal
 * @psalm-immutable
 */
final class ContentLanguageFactory implements Implementation
{
    #[\Override]
    public function __invoke(Str $value): Maybe
    {
        /** @var Sequence<ContentLanguageValue> */
        $values = Sequence::of();

        return $value
            ->split(',')
            ->map(static fn($language) => $language->trim()->toString())
            ->map(ContentLanguageValue::of(...))
            ->sink($values)
            ->maybe(static fn($values, $value) => $value->map($values))
            ->map(static fn($values) => new ContentLanguage(...$values->toList()));
    }
}
