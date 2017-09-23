<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class Referrer extends Header
{
    public function __construct(ReferrerValue $referrer)
    {
        parent::__construct('Referer', $referrer);
    }
}
