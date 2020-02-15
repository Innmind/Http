<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @extends Header<AuthorizationValue>
 */
final class Authorization extends Header
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
