<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Url\Url;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class ContentLocation implements HeaderInterface
{
    private Header $header;
    private LocationValue $value;

    public function __construct(LocationValue $location)
    {
        $this->header = new Header('Content-Location', $location);
        $this->value = $location;
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
        return $this->value->url();
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
