<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<AcceptCharsetValue>
 * @psalm-immutable
 */
final class AcceptCharset implements HeaderInterface
{
    /** @var Header<AcceptCharsetValue> */
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(AcceptCharsetValue ...$values)
    {
        $this->header = new Header('Accept-Charset', ...$values);
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
