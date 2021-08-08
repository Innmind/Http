<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<LinkValue>
 * @psalm-immutable
 */
final class Link implements HeaderInterface
{
    /** @var Header<LinkValue> */
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(LinkValue ...$values)
    {
        $this->header = new Header('Link', ...$values);
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
