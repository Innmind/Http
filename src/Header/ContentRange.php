<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class ContentRange extends Header
{
    public function __construct(ContentRangeValue $range)
    {
        parent::__construct(
            'Content-Range',
            (new Set(HeaderValue::class))
                ->add($range)
        );
    }
}
