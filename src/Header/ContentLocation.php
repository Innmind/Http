<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\Url;

/**
 * @extends Header<LocationValue>
 */
final class ContentLocation extends Header
{
    public function __construct(LocationValue $location)
    {
        parent::__construct('Content-Location', $location);
    }

    public static function of(Url $location): self
    {
        return new self(new LocationValue($location));
    }
}
