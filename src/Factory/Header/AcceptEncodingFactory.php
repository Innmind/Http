<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header\AcceptEncodingValue,
    Header\AcceptEncoding,
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
final class AcceptEncodingFactory implements Implementation
{
    private const PATTERN = '~(?<coding>(\w+|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~';

    #[\Override]
    public function __invoke(Str $value): Maybe
    {
        /** @var Sequence<AcceptEncodingValue> */
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
                $coding = $matches
                    ->get('coding')
                    ->map(static fn($coding) => $coding->toString());

                return Maybe::all($coding, $quality)->flatMap(
                    AcceptEncodingValue::of(...),
                );
            })
            ->sink($values)
            ->maybe(static fn($values, $value) => $value->map($values))
            ->map(static fn($values) => new AcceptEncoding(...$values->toList()));
    }
}
