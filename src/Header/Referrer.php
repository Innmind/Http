<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;
use Innmind\Url\Url;

/**
 * @psalm-immutable
 */
final class Referrer implements Custom
{
    private function __construct(
        private Url $referrer,
    ) {
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(Url $referrer): self
    {
        return new self($referrer);
    }

    #[\NoDiscard]
    public function referrer(): Url
    {
        return $this->referrer;
    }

    #[\Override]
    #[\NoDiscard]
    public function normalize(): Header
    {
        return Header::of(
            'Referer',
            Value::of($this->referrer->toString()),
        );
    }
}
