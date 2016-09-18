<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class ContentLength extends Header
{
    public function __construct(ContentLengthValue $length)
    {
        parent::__construct(
            'Content-Length',
            (new Set(HeaderValueInterface::class))
                ->add($length)
        );
    }
}
