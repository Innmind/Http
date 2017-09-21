<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\{
    SetInterface,
    Set
};

final class ContentLanguage extends Header
{
    public function __construct(SetInterface $values = null)
    {
        $values = $values ?? new Set(HeaderValue::class);

        $values->foreach(function(HeaderValue $value) {
            if (!$value instanceof ContentLanguageValue) {
                throw new InvalidArgumentException;
            }
        });

        parent::__construct('Content-Language', $values);
    }
}
