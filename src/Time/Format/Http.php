<?php
declare(strict_types = 1);

namespace Innmind\Http\Time\Format;

use Innmind\Time\Format;

final class Http
{
    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function new(): Format
    {
        return Format::of('D, d M Y H:i:s \G\M\T');
    }
}
