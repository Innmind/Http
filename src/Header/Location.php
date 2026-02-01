<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;
use Innmind\Url\Url;

/**
 * @psalm-immutable
 */
final class Location implements Custom
{
    private function __construct(
        private Url $location,
    ) {
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(Url $location): self
    {
        return new self($location);
    }

    #[\NoDiscard]
    public function url(): Url
    {
        return $this->location;
    }

    #[\Override]
    #[\NoDiscard]
    public function normalize(): Header
    {
        return Header::of(
            'Location',
            Value::of($this->location->toString()),
        );
    }
}
