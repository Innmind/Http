<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\{
    Str,
    Maybe,
};

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

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(string $language): Maybe
    {
        try {
            return Maybe::just(new self($language));
        } catch (DomainException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
    }

    public function toString(): string
    {
        return $this->language;
    }
}
