<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\ContentLanguage,
    Header\ContentLanguageValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
    Sequence,
};

/**
 * @psalm-immutable
 */
final class ContentLanguageFactory implements HeaderFactory
{
    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'content-language') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

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
