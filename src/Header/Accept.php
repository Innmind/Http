<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<AcceptValue>
 * @implements HeaderInterface<AcceptValue>
 * @psalm-immutable
 */
final class Accept extends Header implements HeaderInterface
{
    public function __construct(AcceptValue $first, AcceptValue ...$values)
    {
        parent::__construct('Accept', $first, ...$values);
    }
}
