<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class Cookie implements HeaderInterface
{
    private Header $header;

    public function __construct(CookieValue $value)
    {
        $this->header = new Header('Cookie', $value);
    }

    /**
     * @no-named-arguments
     * @psalm-pure
     */
    public static function of(Parameter ...$parameters): self
    {
        return new self(new CookieValue(...$parameters));
    }

    public function name(): string
    {
        return $this->header->name();
    }

    public function values(): Set
    {
        return $this->header->values();
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
