<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\{
    Sequence,
    Map,
};

/**
 * @psalm-immutable
 */
final class Cookie implements HeaderInterface
{
    public function __construct(
        private CookieValue $value,
    ) {
    }

    /**
     * @no-named-arguments
     * @psalm-pure
     */
    public static function of(Parameter ...$parameters): self
    {
        return new self(new CookieValue(...$parameters));
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

    /**
     * @return Map<string, Parameter>
     */
    public function parameters(): Map
    {
        return $this->value->parameters();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header('Cookie', $this->value);
    }
}
