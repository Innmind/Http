<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Url\Url;

/**
 * @extends Header<LocationValue>
 * @implements HeaderInterface<LocationValue>
 * @psalm-immutable
 */
final class ContentLocation extends Header implements HeaderInterface
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
