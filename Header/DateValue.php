<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class DateValue extends HeaderValue
{
    public function __construct(\DateTimeInterface $date)
    {
        parent::__construct($date->format(\DateTime::RFC1123));
    }
}
