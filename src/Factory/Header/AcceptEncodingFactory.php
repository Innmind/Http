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
            throw new DomainException;
        }

        $values = $value->split(',');
        $values->foreach(static function(Str $accept): void {
            if (!$accept->matches(self::PATTERN)) {
                throw new DomainException;
            }
        });

        return new AcceptEncoding(
            ...$values->reduce(
                [],
                static function(array $carry, Str $accept): array {
                    $matches = $accept->capture(self::PATTERN);
                    $carry[] = new AcceptEncodingValue(
                        $matches->get('coding')->toString(),
                        new Quality(
                            $matches->contains('quality') ?
                                (float) $matches->get('quality')->toString() : 1,
                        ),
                    );

                    return $carry;
                },
            ),
        );
    }
}
