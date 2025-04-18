<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\Url;

/**
 * @psalm-immutable
 */
final class ReferrerValue implements Value
{
    private Url $url;

    public function __construct(Url $url)
    {
        $this->url = $url;
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
