<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Header\Content\Language,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class ContentLanguage implements Custom
{
    /**
     * @param Sequence<Language> $languages
     */
    private function __construct(
        private Sequence $languages,
    ) {
    }

    /**
     * @no-named-arguments
     * @psalm-pure
     */
    public static function of(Language ...$languages): self
    {
        return new self(Sequence::of(...$languages));
    }

    #[\Override]
    public function normalize(): Header
    {
        return Header::of(
            'Content-Language',
            ...$this
                ->languages
                ->map(static fn($language) => new Value($language->toString()))
                ->toList(),
        );
    }
}
