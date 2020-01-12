<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

final class ContentLanguageValue extends Value\Value
{
    public function __construct(string $language)
    {
        $language = Str::of($language);

        if (!$language->matches('~^[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*$~')) {
            throw new DomainException;
        }

        parent::__construct($language->toString());
    }
}
