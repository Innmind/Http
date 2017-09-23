<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

final class ContentEncodingValue extends Value\Value
{
    public function __construct(string $coding)
    {
        $coding = new Str($coding);

        if (!$coding->matches('~^[\w\-]+$~')) {
            throw new DomainException;
        }

        parent::__construct((string) $coding);
    }
}
