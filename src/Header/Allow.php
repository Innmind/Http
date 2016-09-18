<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\SetInterface;

final class Allow extends Header
{
    public function __construct(SetInterface $values)
    {
        $values->foreach(function(HeaderValueInterface $value) {
            if (!$value instanceof AllowValue) {
                throw new InvalidArgumentException;
            }
        });

        parent::__construct('Allow', $values);
    }
}
