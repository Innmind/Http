<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Message\Method;
use Innmind\Immutable\Str;

final class AllowValue extends Value\Value
{
    public function __construct(string $value)
    {
        new Method($value);

        parent::__construct($value);
    }
}
