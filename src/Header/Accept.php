<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<AcceptValue>
 * @psalm-immutable
 */
final class Accept implements HeaderInterface
{
    /** @var Header<AcceptValue> */
    private Header $header;

    public function __construct(AcceptValue $first, AcceptValue ...$values)
    {
        $this->header = new Header('Accept', $first, ...$values);
    }

    public function name(): string
    {
        return $this->header->name();
    }

    public function values(): Set
    {
        return $this->header->values();
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
