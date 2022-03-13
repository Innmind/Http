<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Url\Url;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class Location implements HeaderInterface
{
    private Header $header;
    private Url $url;

    public function __construct(LocationValue $location)
    {
        $this->header = new Header('Location', $location);
        $this->url = $location->url();
    }

    /**
     * @psalm-pure
     */
    public static function of(Url $location): self
    {
        return new self(new LocationValue($location));
    }

    public function name(): string
    {
        return $this->header->name();
    }

    public function values(): Set
    {
        return $this->header->values();
    }

    public function url(): Url
    {
        return $this->url;
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
