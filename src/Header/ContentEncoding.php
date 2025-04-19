<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class ContentEncoding implements HeaderInterface
{
    private Header $header;

    public function __construct(ContentEncodingValue $encoding)
    {
        $this->header = new Header('Content-Encoding', $encoding);
    }

    /**
     * @psalm-pure
     */
    public static function of(string $coding): self
    {
        return new self(new ContentEncodingValue($coding));
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
