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
    public static function of(Url $referrer): self
    {
        return new self($referrer);
    }

    public function referrer(): Url
    {
        return $this->referrer;
    }

    #[\Override]
    public function normalize(): Header
    {
        return Header::of(
            'Referer',
            new Value($this->referrer->toString()),
        );
    }
}
