<?php
declare(strict_types = 1);

namespace Innmind\Http\TimeContinuum\Format;

use Innmind\TimeContinuum\Format;

final class Http
{
    /**
     * @psalm-pure
     */
    public static function new(): Format
    {
        return Format::of('D, d M Y H:i:s \G\M\T');
    }
}
