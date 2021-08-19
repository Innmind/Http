<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class AcceptEncoding implements HeaderInterface
{
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(AcceptEncodingValue ...$values)
    {
        $this->header = new Header('Accept-Encoding', ...$values);
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
