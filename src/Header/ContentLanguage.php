<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<ContentLanguageValue>
 * @implements HeaderInterface<ContentLanguageValue>
 * @psalm-immutable
 */
final class ContentLanguage extends Header implements HeaderInterface
{
    public function __construct(ContentLanguageValue ...$values)
    {
        parent::__construct('Content-Language', ...$values);
    }

    public static function of(string ...$values): self
    {
        return new self(...\array_map(
            static fn(string $value): ContentLanguageValue => new ContentLanguageValue($value),
            $values,
        ));
    }
}
