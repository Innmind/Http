<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

/**
 * @psalm-immutable
 */
final class ContentLanguageValue implements Value
{
    private string $language;

    public function __construct(string $language)
    {
        if (!Str::of($language)->matches('~^[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*$~')) {
            throw new DomainException($language);
        }

        $this->language = $language;
    }

    public function toString(): string
    {
        return $this->language;
    }
}
