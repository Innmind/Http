<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\Set;

final class Authorization extends Header
{
    public function __construct(AuthorizationValue $authorization)
    {
        parent::__construct(
            'Authorization',
            (new Set(HeaderValueInterface::class))
                ->add($authorization)
        );
    }
}
