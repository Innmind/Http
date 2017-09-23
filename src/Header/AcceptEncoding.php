<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class AcceptEncoding extends Header
{
    public function __construct(AcceptEncodingValue ...$values)
    {
        parent::__construct('Accept-Encoding', ...$values);
    }
}
