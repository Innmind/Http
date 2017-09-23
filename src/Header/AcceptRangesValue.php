<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

final class AcceptRangesValue extends Value\Value
{
    public function __construct(string $range)
    {
        if (!(new Str($range))->matches('~^\w+$~')) {
            throw new DomainException;
        }

        parent::__construct($range);
    }
}
