<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<ContentLengthValue>
 * @psalm-immutable
 */
final class ContentLength implements HeaderInterface
{
    /** @var Header<ContentLengthValue> */
    private Header $header;

    public function __construct(ContentLengthValue $length)
    {
        $this->header = new Header('Content-Length', $length);
    }

    public static function of(int $length): self
    {
        return new self(new ContentLengthValue($length));
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
