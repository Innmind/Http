<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\Url;

/**
 * @psalm-immutable
 */
final class LocationValue implements Value
{
    public function __construct(
        private Url $url,
    ) {
    }

    public function url(): Url
    {
        return $this->url;
    }

    #[\Override]
    public function toString(): string
    {
        return $this->url->toString();
    }
}
