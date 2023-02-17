<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\{
    Set,
    Map,
};

/**
 * @psalm-immutable
 */
final class Cookie implements HeaderInterface
{
    private Header $header;
    private CookieValue $value;

    public function __construct(CookieValue $value)
    {
        $this->header = new Header('Cookie', $value);
        $this->value = $value;
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

    /**
     * @return Map<string, Parameter>
     */
    public function parameters(): Map
    {
        return $this->value->parameters();
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
