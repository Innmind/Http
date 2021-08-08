<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<AcceptCharsetValue>
 * @implements HeaderInterface<AcceptCharsetValue>
 * @psalm-immutable
 */
final class AcceptCharset extends Header implements HeaderInterface
{
    /**
     * @no-named-arguments
     */
    public function __construct(AcceptCharsetValue ...$values)
    {
        parent::__construct('Accept-Charset', ...$values);
    }
}
