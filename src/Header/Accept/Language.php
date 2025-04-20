<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Accept;

use Innmind\Http\Header\Parameter\Quality;
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
        private Str $language,
        private Quality $quality,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(string $language, ?Quality $quality = null): Maybe
    {
        $language = Str::of($language);

        if (
            $language->toString() !== '*' &&
            !$language->matches('~^[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*$~')
        ) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        return Maybe::just(new self($language, $quality ?? Quality::max()));
    }

    public function quality(): Quality
    {
        return $this->quality;
    }

    public function toString(): string
    {
        return $this
            ->language
            ->append(';')
            ->append($this->quality->toParameter()->toString())
            ->toString();
    }
}
