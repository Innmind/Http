<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class Authorization extends Header
{
    public function __construct(AuthorizationValue $authorization)
    {
        parent::__construct('Authorization', $authorization);
    }
}
