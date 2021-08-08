<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<CookieValue>
 * @implements HeaderInterface<CookieValue>
 * @psalm-immutable
 */
final class SetCookie extends Header implements HeaderInterface
{
    /**
     * @no-named-arguments
     */
    public function __construct(CookieValue ...$values)
    {
        parent::__construct('Set-Cookie', ...$values);
    }

    /**
     * @no-named-arguments
     */
    public static function of(Parameter ...$values): self
    {
        return new self(new CookieValue(...$values));
    }
}
