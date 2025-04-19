<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Url\Url;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Referrer implements HeaderInterface
{
    public function __construct(
        private ReferrerValue $referrer,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Url $referrer): self
    {
        return new self(new ReferrerValue($referrer));
    }

    #[\Override]
    public function name(): string
    {
        return $this->header()->name();
    }

    #[\Override]
    public function values(): Sequence
    {
        return $this->header()->values();
    }

    public function referrer(): Url
    {
        return $this->referrer->url();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header('Referer', $this->referrer);
    }
}
