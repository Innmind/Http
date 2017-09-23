<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class ContentType extends Header
{
    public function __construct(ContentTypeValue $content)
    {
        parent::__construct(
            'Content-Type',
            (new Set(Value::class))
                ->add($content)
        );
    }
}
