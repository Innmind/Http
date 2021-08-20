<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\Value,
    Header\AcceptCharsetValue,
    Header\AcceptCharset,
    Header\Parameter\Quality,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

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
                $quality = $matches->get('quality')->match(
                    static fn($quality) => (float) $quality->toString(),
                    static fn() => 1,
                );

                return $matches
                    ->get('charset')
                    ->map(static fn($charset) => new AcceptCharsetValue(
                        $charset->toString(),
                        new Quality($quality),
                    ));
            });

        if ($values->empty()) {
            /** @var Maybe<Header> */
            return Maybe::just(new AcceptCharset);
        }

        /**
         * @psalm-suppress NamedArgumentNotAllowed
         * @var Maybe<Header>
         */
        return Maybe::all(...$values->toList())->map(
            static fn(AcceptCharsetValue ...$values) => new AcceptCharset(...$values),
        );
    }
}
