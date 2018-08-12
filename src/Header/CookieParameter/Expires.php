<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\{
    Header\Parameter\Parameter,
    TimeContinuum\Format\Http
};
use Innmind\TimeContinuum\PointInTimeInterface;

final class Expires extends Parameter
{
    public function __construct(PointInTimeInterface $date)
    {
        parent::__construct('Expires', $date->format(new Http));
    }
}
