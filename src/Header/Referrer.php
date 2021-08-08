<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Url\Url;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<ReferrerValue>
 * @psalm-immutable
 */
final class Referrer implements HeaderInterface
{
    /** @var Header<ReferrerValue> */
    private Header $header;

    public function __construct(ReferrerValue $referrer)
    {
        $this->header = new Header('Referer', $referrer);
    }

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
