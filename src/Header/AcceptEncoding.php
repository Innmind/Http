<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<AcceptEncodingValue>
 * @implements HeaderInterface<AcceptEncodingValue>
 */
final class AcceptEncoding extends Header implements HeaderInterface
{
    public function __construct(AcceptEncodingValue ...$values)
    {
        parent::__construct('Accept-Encoding', ...$values);
    }
}
