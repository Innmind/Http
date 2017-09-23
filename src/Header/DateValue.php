<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\TimeContinuum\Format\Http;
use Innmind\TimeContinuum\PointInTimeInterface;

final class DateValue extends Value\Value
{
    public function __construct(PointInTimeInterface $date)
    {
        parent::__construct($date->format(new Http));
    }
}
