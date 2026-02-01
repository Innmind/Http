<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Content;

use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Language
{
    private function __construct(
        private string $language,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    #[\NoDiscard]
    public static function maybe(string $language): Maybe
    {
        if (!Str::of($language)->matches('~^[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*$~')) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        return Maybe::just(new self($language));
    }

    #[\NoDiscard]
    public function toString(): string
    {
        return $this->language;
    }
}
