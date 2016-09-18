<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class Range extends Header
{
    public function __construct(RangeValue $range)
    {
        parent::__construct(
            'Range',
            (new Set(HeaderValueInterface::class))
                ->add($range)
        );
    }
}
