<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;
use Innmind\Url\Url;

/**
 * @psalm-immutable
 */
final class ContentLocation implements Custom
{
    private function __construct(
        private Url $url,
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
        return $this->url;
    }

    #[\Override]
    public function normalize(): Header
    {
        return Header::of(
            'Content-Location',
            Value::of($this->url->toString()),
        );
    }
}
