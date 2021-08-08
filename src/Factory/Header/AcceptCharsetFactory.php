<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\AcceptCharsetValue,
    Header\AcceptCharset,
    Header\Parameter\Quality,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class AcceptCharsetFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~(?<charset>[a-zA-Z0-9\-_:\(\)]+)(; ?q=(?<quality>\d+(\.\d+)?))?~';

    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'accept-charset') {
            throw new DomainException($name->toString());
        }

        $values = $value
            ->split(',')
            ->map(static function(Str $accept): AcceptCharsetValue {
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
                    ))
                    ->match(
                        static fn($value) => $value,
                        static fn() => throw new DomainException($accept->toString()),
                    );
            })
            ->toList();

        return new AcceptCharset(...$values);
    }
}
