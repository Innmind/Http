<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<ContentLanguageValue>
 * @psalm-immutable
 */
final class ContentLanguage implements HeaderInterface
{
    /** @var Header<ContentLanguageValue> */
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(ContentLanguageValue ...$values)
    {
        $this->header = new Header('Content-Language', ...$values);
    }

    /**
     * @no-named-arguments
     * @psalm-pure
     */
    public static function of(string ...$values): self
    {
        return new self(...\array_map(
            static fn(string $value): ContentLanguageValue => new ContentLanguageValue($value),
            $values,
        ));
    }

    public function name(): string
    {
        return $this->header->name();
    }

    public function values(): Set
    {
        return $this->header->values();
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
