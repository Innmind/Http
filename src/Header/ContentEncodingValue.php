<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

/**
 * @psalm-immutable
 */
final class ContentEncodingValue implements Value
{
    private string $coding;

    public function __construct(string $coding)
    {
        if (!Str::of($coding)->matches('~^[\w\-]+$~')) {
            throw new DomainException($coding);
        }

        $this->coding = $coding;
    }

    public function toString(): string
    {
        return $this->coding;
    }
}
