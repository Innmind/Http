<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class Allow extends Header
{
    public function __construct(AllowValue ...$values)
    {
        parent::__construct('Allow', ...$values);
    }
}
