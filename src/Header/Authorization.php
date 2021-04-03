<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<AuthorizationValue>
 * @implements HeaderInterface<AuthorizationValue>
 */
final class Authorization extends Header implements HeaderInterface
{
    public function __construct(AuthorizationValue $authorization)
    {
        parent::__construct('Authorization', $authorization);
    }

    public static function of(string $scheme, string $parameter): self
    {
        return new self(new AuthorizationValue($scheme, $parameter));
    }
}
