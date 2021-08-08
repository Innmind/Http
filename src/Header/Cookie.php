<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<CookieValue>
 * @implements HeaderInterface<CookieValue>
 * @psalm-immutable
 */
final class Cookie extends Header implements HeaderInterface
{
    public function __construct(CookieValue $value)
    {
        parent::__construct('Cookie', $value);
    }

    public static function of(Parameter ...$parameters): self
    {
        return new self(new CookieValue(...$parameters));
    }
}
