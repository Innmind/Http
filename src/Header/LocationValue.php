<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\UrlInterface;

final class LocationValue extends HeaderValue\HeaderValue
{
    public function __construct(UrlInterface $url)
    {
        parent::__construct((string) $url);
    }
}
