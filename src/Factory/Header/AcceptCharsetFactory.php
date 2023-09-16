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
};

/**
 * @psalm-immutable
 */
final class AcceptCharsetFactory implements HeaderFactory
{
    private const PATTERN = '~(?<charset>[a-zA-Z0-9\-_:\(\)]+)(; ?q=(?<quality>\d+(\.\d+)?))?~';

    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'accept-charset') {
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

                return Maybe::all($matches->get('charset'), $quality)->flatMap(
                    static fn(Str $charset, Quality $quality) => AcceptCharsetValue::of(
                        $charset->toString(),
                        $quality,
                    ),
                );
            });

        if ($values->empty()) {
            /** @var Maybe<Header> */
            return Maybe::just(new AcceptCharset);
        }

        /**
         * @psalm-suppress NamedArgumentNotAllowed
         * @psalm-suppress InvalidArgument
         * @var Maybe<Header>
         */
        return Maybe::all(...$values->toList())->map(
            static fn(AcceptCharsetValue ...$values) => new AcceptCharset(...$values),
        );
    }
}
