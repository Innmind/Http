<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\UrlInterface;

final class ReferrerValue extends Value\Value
{
    public function __construct(UrlInterface $url)
    {
        parent::__construct((string) $url);
    }
}
