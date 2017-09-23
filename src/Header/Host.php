<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class Host extends Header
{
    public function __construct(HostValue $host)
    {
        parent::__construct(
            'Host',
            (new Set(Value::class))
                ->add($host)
        );
    }
}
