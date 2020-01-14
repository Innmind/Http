<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header\Parameter\Quality,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class AcceptLanguageValue extends Value\Value
{
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

        $this->quality = $quality;
        parent::__construct(
            $language
                ->append(';')
                ->append($quality->toString())
                ->toString(),
        );
    }

    public function quality(): Quality
    {
        return $this->quality;
    }
}
