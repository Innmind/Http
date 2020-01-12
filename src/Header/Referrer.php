<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\Url;

final class Referrer extends Header
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
