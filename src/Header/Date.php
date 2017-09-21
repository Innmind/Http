<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class Date extends Header
{
    public function __construct(DateValue $date)
    {
        parent::__construct(
            'Date',
            (new Set(HeaderValue::class))
                ->add($date)
        );
    }
}
