<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Url\Url;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class ContentLocation implements HeaderInterface
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

    #[\Override]
    public function name(): string
    {
        return $this->header()->name();
    }

    #[\Override]
    public function values(): Sequence
    {
        return $this->header()->values();
    }

    public function url(): Url
    {
        return $this->url;
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header('Content-Location', new Value\Value($this->url->toString()));
    }
}
