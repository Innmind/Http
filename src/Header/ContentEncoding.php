<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class ContentEncoding extends Header
{
    public function __construct(ContentEncodingValue $encoding)
    {
        parent::__construct(
            'Content-Encoding',
            (new Set(Value::class))
                ->add($encoding)
        );
    }
}
