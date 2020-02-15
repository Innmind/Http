<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @extends Header<WWWAuthenticateValue>
 */
final class WWWAuthenticate extends Header
{
    public function __construct(WWWAuthenticateValue ...$values)
    {
        parent::__construct('WWW-Authenticate', ...$values);
    }
}
