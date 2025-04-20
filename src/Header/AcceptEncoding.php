<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Header\Accept\Encoding,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class AcceptEncoding implements Custom
{
    /**
     * @param Sequence<Encoding> $encodings
     */
    private function __construct(
        private Sequence $encodings,
    ) {
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    public static function of(Encoding ...$encodings): self
    {
        return new self(Sequence::of(...$encodings));
    }

    #[\Override]
    public function normalize(): Header
    {
        return Header::of(
            'Accept-Encoding',
            ...$this
                ->encodings
                ->map(static fn($value) => Value::of($value->toString()))
                ->toList(),
        );
    }
}
