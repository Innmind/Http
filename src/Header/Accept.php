<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @extends Header<AcceptValue>
 */
final class Accept extends Header
{
    public function __construct(AcceptValue $first, AcceptValue ...$values)
    {
        parent::__construct('Accept', $first, ...$values);
    }
}
