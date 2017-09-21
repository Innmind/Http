<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class LastModified extends Header
{
    public function __construct(DateValue $date)
    {
        parent::__construct(
            'Last-Modified',
            (new Set(HeaderValue::class))
                ->add($date)
        );
    }
}
