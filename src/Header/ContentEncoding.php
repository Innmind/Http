<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class ContentEncoding extends Header
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
