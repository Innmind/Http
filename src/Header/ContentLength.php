<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class ContentLength implements HeaderInterface
{
    private Header $header;
    private ContentLengthValue $value;

    public function __construct(ContentLengthValue $length)
    {
        $this->header = new Header('Content-Length', $length);
        $this->value = $length;
    }

    /**
     * @psalm-pure
     */
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

    /**
     * @return 0|positive-int
     */
    public function length(): int
    {
        return $this->value->length();
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
