<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;
use Innmind\Immutable\Map;

/**
 * @psalm-immutable
 */
final class Cookie implements Custom
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

    /**
     * @return Map<string, Parameter>
     */
    public function parameters(): Map
    {
        return $this->value->parameters();
    }

    #[\Override]
    public function normalize(): Header
    {
        return new Header('Cookie', $this->value);
    }
}
