<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class SetCookie implements HeaderInterface
{
    private Header $header;
    /** @var Sequence<CookieValue> */
    private Sequence $cookies;

    /**
     * @no-named-arguments
     */
    public function __construct(CookieValue ...$values)
    {
        $this->header = new Header('Set-Cookie', ...$values);
        $this->cookies = Sequence::of(...$values);
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
    public function values(): Sequence
    {
        return $this->header->values();
    }

    /**
     * @return Sequence<CookieValue>
     */
    public function cookies(): Sequence
    {
        return $this->cookies;
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header->toString();
    }
}
