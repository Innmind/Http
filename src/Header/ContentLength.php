<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class ContentLength extends Header
{
    public function __construct(ContentLengthValue $length)
    {
        parent::__construct('Content-Length', $length);
    }
}
