<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\Value,
    Header\AcceptLanguageValue,
    Header\AcceptLanguage,
    Header\Parameter\Quality,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class AcceptLanguageFactory implements HeaderFactory
{
    private const PATTERN = '~(?<lang>([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~';

    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'accept-language') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        $values = $value
            ->split(',')
            ->map(static function(Str $accept) {
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
                    ));
            });

        if ($values->empty()) {
            /** @var Maybe<Header> */
            return Maybe::just(new AcceptLanguage);
        }

        /**
         * @psalm-suppress NamedArgumentNotAllowed
         * @var Maybe<Header>
         */
        return Maybe::all(...$values->toList())->map(
            static fn(AcceptLanguageValue ...$values) => new AcceptLanguage(...$values)
        );
    }
}
