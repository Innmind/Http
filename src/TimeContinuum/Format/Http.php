<?php
declare(strict_types = 1);

namespace Innmind\Http\TimeContinuum\Format;

use Innmind\TimeContinuum\Format;

final class Http implements Format
{
    public function toString(): string
    {
        return 'D, d M Y H:i:s \G\M\T';
    }
}
