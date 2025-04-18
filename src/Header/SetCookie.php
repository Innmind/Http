<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class SetCookie implements HeaderInterface
{
    private Header $header;
    /** @var Set<CookieValue> */
    private Set $cookies;

    /**
     * @no-named-arguments
     */
    public function __construct(CookieValue ...$values)
    {
        $this->header = new Header('Set-Cookie', ...$values);
        $this->cookies = Set::of(...$values);
    }

    /**
     * @no-named-arguments
     * @psalm-pure
     */
    public static function of(Parameter ...$values): self
    {
        return new self(new CookieValue(...$values));
    }

    #[\Override]
    public function name(): string
    {
        return $this->header->name();
    }

    #[\Override]
    public function values(): Set
    {
        return $this->header->values();
    }

    /**
     * @return Set<CookieValue>
     */
    public function cookies(): Set
    {
        return $this->cookies;
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header->toString();
    }
}
