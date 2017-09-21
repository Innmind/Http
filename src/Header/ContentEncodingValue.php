<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\Str;

final class ContentEncodingValue extends HeaderValue\HeaderValue
{
    public function __construct(string $coding)
    {
        $coding = new Str($coding);

        if (!$coding->matches('~^[\w\-]+$~')) {
            throw new InvalidArgumentException;
        }

        parent::__construct((string) $coding);
    }
}
