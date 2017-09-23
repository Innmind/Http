<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class Location extends Header
{
    public function __construct(LocationValue $location)
    {
        parent::__construct(
            'Location',
            (new Set(Value::class))
                ->add($location)
        );
    }
}
