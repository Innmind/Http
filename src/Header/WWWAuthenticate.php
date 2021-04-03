<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<WWWAuthenticateValue>
 * @implements HeaderInterface<WWWAuthenticateValue>
 */
final class WWWAuthenticate extends Header implements HeaderInterface
{
    public function __construct(WWWAuthenticateValue ...$values)
    {
        parent::__construct('WWW-Authenticate', ...$values);
    }
}
