<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\UrlInterface;

final class Referrer extends Header
{
    public function __construct(ReferrerValue $referrer)
    {
        parent::__construct('Referer', $referrer);
    }

    public static function of(UrlInterface $referrer): self
    {
        return new self(new ReferrerValue($referrer));
    }
}
