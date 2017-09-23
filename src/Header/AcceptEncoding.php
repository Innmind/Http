<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\{
    SetInterface,
    Set
};

final class AcceptEncoding extends Header
{
    public function __construct(SetInterface $values = null)
    {
        $values = $values ?? new Set(Value::class);

        $values->foreach(function(Value $value) {
            if (!$value instanceof AcceptEncodingValue) {
                throw new InvalidArgumentException;
            }
        });

        parent::__construct('Accept-Encoding', $values);
    }
}
