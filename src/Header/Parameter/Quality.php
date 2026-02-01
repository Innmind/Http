<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Parameter;

use Innmind\Http\Header\Parameter;
use Innmind\Immutable\Str;

/**
 * @psalm-immutable
 */
final class Quality
{
    /**
     * @param int<0, 100> $percent
     */
    private function __construct(
        private int $percent,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @param int<0, 100> $percent
     */
    #[\NoDiscard]
    public static function of(int $percent): self
    {
        return new self($percent);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function max(): self
    {
        return new self(100);
    }

    #[\NoDiscard]
    public function toParameter(): Parameter
    {
        $value = Str::of(\sprintf(
            '%0.2f',
            $this->percent / 100,
        ));

        return Parameter::of('q', match (true) {
            $value->endsWith('.00') => $value->dropEnd(3)->toString(),
            $value->endsWith('0') => $value->dropEnd(1)->toString(),
            default => $value->toString(),
        });
    }
}
