<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\Set;

final class Age extends Header
{
    public function __construct(AgeValue $age)
    {
        parent::__construct(
            'Age',
            (new Set(HeaderValueInterface::class))
                ->add($age)
        );
    }
}
