<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

/**
 * @psalm-immutable
 */
final class ContentEncodingValue extends Value\Value
{
    public function __construct(string $coding)
    {
        $coding = Str::of($coding);

        if (!$coding->matches('~^[\w\-]+$~')) {
            throw new DomainException($coding->toString());
        }

        parent::__construct($coding->toString());
    }
}
