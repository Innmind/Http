<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Header\Accept\Charset,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class AcceptCharset implements Custom
{
    /**
     * @param Sequence<Charset> $charsets
     */
    private function __construct(
        private Sequence $charsets,
    ) {
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    #[\NoDiscard]
    public static function of(Charset ...$charsets): self
    {
        return new self(Sequence::of(...$charsets));
    }

    #[\Override]
    #[\NoDiscard]
    public function normalize(): Header
    {
        return Header::of(
            'Accept-Charset',
            ...$this
                ->charsets
                ->map(static fn($value) => Value::of($value->toString()))
                ->toList(),
        );
    }
}
