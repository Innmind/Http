<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\Str;

final class AcceptLanguageValue extends HeaderValue
{
    private $quality;

    public function __construct(string $language, Quality $quality)
    {
        $language = new Str($language);

        if (
            (string) $language !== '*' &&
            !$language->matches('~^[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*$~')
        ) {
            throw new InvalidArgumentException;
        }

        $this->quality = $quality;
        parent::__construct(
            (string) $language
                ->append(';')
                ->append((string) $quality)
        );
    }

    public function quality(): Quality
    {
        return $this->quality;
    }
}
