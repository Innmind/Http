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
};

final class ContentLanguageFactory implements HeaderFactory
{
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'content-language') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        $values = $value
            ->split(',')
            ->map(static fn($language) => $language->trim()->toString())
            ->map(static fn($language) => ContentLanguageValue::of($language));

        if ($values->empty()) {
            /** @var Maybe<Header> */
            return Maybe::just(new ContentLanguage);
        }

        /**
         * @psalm-suppress NamedArgumentNotAllowed
         * @var Maybe<Header>
         */
        return Maybe::all(...$values->toList())->map(
            static fn(ContentLanguageValue ...$values) => new ContentLanguage(...$values),
        );
    }
}
