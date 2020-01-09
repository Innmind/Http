<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\UrlInterface;

final class Location extends Header
{
    public function __construct(LocationValue $location)
    {
        parent::__construct('Location', $location);
    }

    public static function of(UrlInterface $location): self
    {
        return new self(new LocationValue($location));
    }
}
