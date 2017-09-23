<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class Expires extends Header
{
    public function __construct(DateValue $date)
    {
        parent::__construct(
            'Expires',
            (new Set(Value::class))
                ->add($date)
        );
    }
}
