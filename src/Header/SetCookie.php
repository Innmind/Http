<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class SetCookie implements Provider
{
    /** @var Sequence<CookieValue> */
    private Sequence $cookies;

    /**
     * @no-named-arguments
     */
    public function __construct(CookieValue ...$values)
    {
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

    /**
     * @return Sequence<CookieValue>
     */
    public function cookies(): Sequence
    {
        return $this->cookies;
    }

    #[\Override]
    public function toHeader(): Header
    {
        return new Header('Set-Cookie', ...$this->cookies->toList());
    }
}
