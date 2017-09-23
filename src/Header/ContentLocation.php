<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class ContentLocation extends Header
{
    public function __construct(LocationValue $location)
    {
        parent::__construct(
            'Content-Location',
            (new Set(Value::class))
                ->add($location)
        );
    }
}
