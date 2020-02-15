<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @extends Header<AcceptCharsetValue>
 */
final class AcceptCharset extends Header
{
    public function __construct(AcceptCharsetValue ...$values)
    {
        parent::__construct('Accept-Charset', ...$values);
    }
}
