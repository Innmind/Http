<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

final class AcceptRangesValue extends Value\Value
{
    public function __construct(string $range)
    {
        if (!Str::of($range)->matches('~^\w+$~')) {
            throw new DomainException($range);
        }

        parent::__construct($range);
    }
}
