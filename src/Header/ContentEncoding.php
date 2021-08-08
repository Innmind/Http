<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<ContentEncodingValue>
 * @psalm-immutable
 */
final class ContentEncoding implements HeaderInterface
{
    /** @var Header<ContentEncodingValue> */
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
