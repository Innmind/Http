<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Sequence;

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

    /**
     * @return 0|positive-int
     */
    public function length(): int
    {
        return $this->value->length();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header->toString();
    }
}
