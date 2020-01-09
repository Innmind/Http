<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header\Parameter\Quality,
    Exception\DomainException
};
use Innmind\Immutable\Str;

final class AcceptLanguageValue extends Value\Value
{
    private $quality;

    public function __construct(string $language, Quality $quality = null)
    {
        $language = new Str($language);
        $quality = $quality ?? new Quality(1);

        if (
            (string) $language !== '*' &&
            !$language->matches('~^[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*$~')
        ) {
            throw new DomainException;
        }

        $this->quality = $quality;
        parent::__construct(
            (string) $language
                ->append(';')
                ->append($quality->toString())
        );
    }

    public function quality(): Quality
    {
        return $this->quality;
    }
}
