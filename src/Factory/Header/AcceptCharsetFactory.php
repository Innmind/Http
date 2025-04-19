<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\AcceptCharsetValue,
    Header\AcceptCharset,
    Header\Parameter\Quality,
};
use Innmind\Immutable\{
    Str,
    Maybe,
    Sequence,
};

/**
 * @psalm-immutable
 */
final class AcceptCharsetFactory implements HeaderFactory
{
    private const PATTERN = '~(?<charset>[a-zA-Z0-9\-_:\(\)]+)(; ?q=(?<quality>\d+(\.\d+)?))?~';

    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'accept-charset') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Sequence<AcceptCharsetValue> */
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
                $charset = $matches
                    ->get('charset')
                    ->map(static fn($charset) => $charset->toString());

                return Maybe::all($charset, $quality)->flatMap(
                    AcceptCharsetValue::of(...),
                );
            })
            ->sink($values)
            ->maybe(static fn($values, $value) => $value->map($values))
            ->map(static fn($values) => new AcceptCharset(...$values->toList()));
    }
}
