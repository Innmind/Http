<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class IfModifiedSince extends Header
{
    public function __construct(DateValue $date)
    {
        parent::__construct(
            'If-Modified-Since',
            (new Set(HeaderValueInterface::class))
                ->add($date)
        );
    }
}
