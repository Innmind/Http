<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<ContentLengthValue>
 * @implements HeaderInterface<ContentLengthValue>
 */
final class ContentLength extends Header implements HeaderInterface
{
    public function __construct(ContentLengthValue $length)
    {
        parent::__construct('Content-Length', $length);
    }

    public static function of(int $length): self
    {
        return new self(new ContentLengthValue($length));
    }
}
