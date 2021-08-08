<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<ContentEncodingValue>
 * @implements HeaderInterface<ContentEncodingValue>
 * @psalm-immutable
 */
final class ContentEncoding extends Header implements HeaderInterface
{
    public function __construct(ContentEncodingValue $encoding)
    {
        parent::__construct('Content-Encoding', $encoding);
    }

    public static function of(string $coding): self
    {
        return new self(new ContentEncodingValue($coding));
    }
}
