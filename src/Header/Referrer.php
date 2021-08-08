<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Url\Url;

/**
 * @extends Header<ReferrerValue>
 * @implements HeaderInterface<ReferrerValue>
 * @psalm-immutable
 */
final class Referrer extends Header implements HeaderInterface
{
    public function __construct(ReferrerValue $referrer)
    {
        parent::__construct('Referer', $referrer);
    }

    public static function of(Url $referrer): self
    {
        return new self(new ReferrerValue($referrer));
    }
}
