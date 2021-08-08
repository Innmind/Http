<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\AcceptEncodingValue,
    Header\AcceptEncoding,
    Header\Parameter\Quality,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class AcceptEncodingFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~(?<coding>(\w+|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~';

    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'accept-encoding') {
            throw new DomainException($name->toString());
        }

        $values = $value->split(',');
        $_ = $values->foreach(static function(Str $accept): void {
            if (!$accept->matches(self::PATTERN)) {
                throw new DomainException($accept->toString());
            }
        });

        /** @var list<AcceptEncodingValue> */
        $values = $values->reduce(
            [],
            static function(array $carry, Str $accept): array {
                $matches = $accept->capture(self::PATTERN);
                $quality = $matches->get('quality')->match(
                    static fn($quality) => (float) $quality->toString(),
                    static fn() => 1,
                );
                $carry[] = $matches
                    ->get('coding')
                    ->map(static fn($coding) => new AcceptEncodingValue(
                        $coding->toString(),
                        new Quality($quality),
                    ))
                    ->match(
                        static fn($value) => $value,
                        static fn() => throw new DomainException,
                    );

                return $carry;
            },
        );

        return new AcceptEncoding(...$values);
    }
}
