<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Url\Url;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class Referrer implements HeaderInterface
{
    private Header $header;

    public function __construct(ReferrerValue $referrer)
    {
        $this->header = new Header('Referer', $referrer);
    }

    /**
     * @psalm-pure
     */
    public static function of(Url $referrer): self
    {
        return new self(new ReferrerValue($referrer));
    }

    public function name(): string
    {
        return $this->header->name();
    }

    public function values(): Set
    {
        return $this->header->values();
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
