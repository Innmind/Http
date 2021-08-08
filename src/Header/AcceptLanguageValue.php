<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header\Parameter\Quality,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

/**
 * @psalm-immutable
 */
final class AcceptLanguageValue implements Value
{
    private Str $language;
    private Quality $quality;

    public function __construct(string $language, Quality $quality = null)
    {
        $language = Str::of($language);
        $quality = $quality ?? new Quality(1);

        if (
            $language->toString() !== '*' &&
            !$language->matches('~^[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*$~')
        ) {
            throw new DomainException($language->toString());
        }

        $this->language = $language;
        $this->quality = $quality;
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
            ->append($this->quality->toString())
            ->toString();
    }
}
