<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\Url;

/**
 * @psalm-immutable
 */
final class Location implements Provider
{
    private function __construct(
        private Url $location,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Url $location): self
    {
        return new self($location);
    }

    public function url(): Url
    {
        return $this->location;
    }

    #[\Override]
    public function toHeader(): Header
    {
        return new Header(
            'Location',
            new Value\Value($this->location->toString()),
        );
    }
}
