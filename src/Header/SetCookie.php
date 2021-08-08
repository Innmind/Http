<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<CookieValue>
 * @psalm-immutable
 */
final class SetCookie implements HeaderInterface
{
    /** @var Header<CookieValue> */
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(CookieValue ...$values)
    {
        $this->header = new Header('Set-Cookie', ...$values);
    }

    /**
     * @no-named-arguments
     */
    public static function of(Parameter ...$values): self
    {
        return new self(new CookieValue(...$values));
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
