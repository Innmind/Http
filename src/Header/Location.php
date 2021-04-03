<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Url\Url;

/**
 * @extends Header<LocationValue>
 * @implements HeaderInterface<LocationValue>
 */
final class Location extends Header implements HeaderInterface
{
    public function __construct(LocationValue $location)
    {
        parent::__construct('Location', $location);
    }

    public static function of(Url $location): self
    {
        return new self(new LocationValue($location));
    }
}
