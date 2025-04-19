<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header\AcceptLanguageValue,
    Header\AcceptLanguage,
    Header\Parameter\Quality,
};
use Innmind\Immutable\{
    Str,
    Maybe,
    Sequence,
};

/**
 * @internal
 * @psalm-immutable
 */
final class AcceptLanguageFactory implements Implementation
{
    private const PATTERN = '~(?<lang>([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~';

    #[\Override]
    public function __invoke(Str $value): Maybe
    {
        /** @var Sequence<AcceptLanguageValue> */
        $values = Sequence::of();

        return $value
            ->split(',')
            ->map(static function(Str $accept) {
                $matches = $accept->capture(self::PATTERN);
                $quality = $matches
                    ->get('quality')
                    ->map(static fn($quality) => (float) $quality->toString())
                    ->otherwise(static fn() => Maybe::just(1))
                    ->flatMap(Quality::of(...));
                $lang = $matches
                    ->get('lang')
                    ->map(static fn($lang) => $lang->toString());

                return Maybe::all($lang, $quality)->flatMap(
                    AcceptLanguageValue::of(...),
                );
            })
            ->sink($values)
            ->maybe(static fn($values, $value) => $value->map($values))
            ->map(static fn($values) => new AcceptLanguage(...$values->toList()));
    }
}
