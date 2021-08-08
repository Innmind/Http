<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\AcceptLanguageValue,
    Header\AcceptLanguage,
    Header\Parameter\Quality,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class AcceptLanguageFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~(?<lang>([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~';

    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'accept-language') {
            throw new DomainException($name->toString());
        }

        $values = $value
            ->split(',')
            ->map(static function(Str $accept): AcceptLanguageValue {
                $matches = $accept->capture(self::PATTERN);
                $quality = $matches->get('quality')->match(
                    static fn($quality) => (float) $quality->toString(),
                    static fn() => 1,
                );

                return $matches
                    ->get('lang')
                    ->map(static fn($lang) => new AcceptLanguageValue(
                        $lang->toString(),
                        new Quality($quality),
                    ))
                    ->match(
                        static fn($lang) => $lang,
                        static fn() => throw new DomainException($accept->toString()),
                    );
            })
            ->toList();

        return new AcceptLanguage(...$values);
    }
}
