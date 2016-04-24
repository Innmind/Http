<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class ContentEncodingValue extends HeaderValue
{
    public function __construct(string $coding)
    {
        $coding = new Str($coding);

        if (!$coding->match('~^\w+$~')) {
            throw new InvalidArgumentException;
        }

        parent::__construct((string) $coding);
    }
}
