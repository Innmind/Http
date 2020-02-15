<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @extends Header<ContentLanguageValue>
 */
final class ContentLanguage extends Header
{
    public function __construct(ContentLanguageValue ...$values)
    {
        parent::__construct('Content-Language', ...$values);
    }

    public static function of(string ...$values): self
    {
        return new self(...\array_map(
            fn(string $value): ContentLanguageValue => new ContentLanguageValue($value),
            $values,
        ));
    }
}
