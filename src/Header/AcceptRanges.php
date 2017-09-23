<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class AcceptRanges extends Header
{
    public function __construct(AcceptRangesValue $ranges)
    {
        parent::__construct(
            'Accept-Ranges',
            (new Set(Value::class))
                ->add($ranges)
        );
    }
}
