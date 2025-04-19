<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Accept implements HeaderInterface
{
    private Header $header;

    public function __construct(AcceptValue $first, AcceptValue ...$values)
    {
        $this->header = new Header('Accept', $first, ...$values);
    }

    #[\Override]
    public function name(): string
    {
        return $this->header->name();
    }

    #[\Override]
    public function values(): Sequence
    {
        return $this->header->values();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header->toString();
    }
}
