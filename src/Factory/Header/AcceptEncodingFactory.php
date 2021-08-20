<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\Value,
    Header\AcceptEncodingValue,
    Header\AcceptEncoding,
    Header\Parameter\Quality,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class AcceptEncodingFactory implements HeaderFactory
{
    private const PATTERN = '~(?<coding>(\w+|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~';

    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'accept-encoding') {
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
                    ->get('coding')
                    ->map(static fn($coding) => new AcceptEncodingValue(
                        $coding->toString(),
                        new Quality($quality),
                    ));
            });

        if ($values->empty()) {
            /** @var Maybe<Header> */
            return Maybe::just(new AcceptEncoding);
        }

        /**
         * @psalm-suppress NamedArgumentNotAllowed
         * @var Maybe<Header>
         */
        return Maybe::all(...$values->toList())->map(
            static fn(AcceptEncodingValue ...$values) => new AcceptEncoding(...$values),
        );
    }
}
