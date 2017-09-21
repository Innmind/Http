<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\Str;

final class ContentLanguageValue extends HeaderValue\HeaderValue
{
    public function __construct(string $language)
    {
        $language = new Str($language);

        if (!$language->matches('~^[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*$~')) {
            throw new InvalidArgumentException;
        }

        parent::__construct((string) $language);
    }
}
