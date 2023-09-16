<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\AcceptLanguageValue,
    Header\AcceptLanguage,
    Header\Parameter\Quality,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
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
                $quality = $matches
                    ->get('quality')
                    ->map(static fn($quality) => (float) $quality->toString())
                    ->otherwise(static fn() => Maybe::just(1))
                    ->flatMap(static fn($quality) => Quality::of($quality));

                return Maybe::all($matches->get('lang'), $quality)->flatMap(
                    static fn(Str $lang, Quality $quality) => AcceptLanguageValue::of(
                        $lang->toString(),
                        $quality,
                    ),
                );
            });

        if ($values->empty()) {
            /** @var Maybe<Header> */
            return Maybe::just(new AcceptLanguage);
        }

        /**
         * @psalm-suppress NamedArgumentNotAllowed
         * @psalm-suppress InvalidArgument
         * @var Maybe<Header>
         */
        return Maybe::all(...$values->toList())->map(
            static fn(AcceptLanguageValue ...$values) => new AcceptLanguage(...$values),
        );
    }
}
