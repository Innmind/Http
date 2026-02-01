<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Header\Accept\Language,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class AcceptLanguage implements Custom
{
    /**
     * @param Sequence<Language> $languages
     */
    private function __construct(
        private Sequence $languages,
    ) {
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    #[\NoDiscard]
    public static function of(Language ...$languages): self
    {
        return new self(Sequence::of(...$languages));
    }

    #[\Override]
    #[\NoDiscard]
    public function normalize(): Header
    {
        return Header::of(
            'Accept-Language',
            ...$this
                ->languages
                ->map(static fn($value) => Value::of($value->toString()))
                ->toList(),
        );
    }
}
