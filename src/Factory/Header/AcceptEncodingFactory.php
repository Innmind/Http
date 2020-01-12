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
    Exception\DomainException
};
use Innmind\Immutable\{
    Str,
    Set
};

final class AcceptEncodingFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~(?<coding>(\w+|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~';

    public function __invoke(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'accept-encoding') {
            throw new DomainException;
        }

        return new AcceptEncoding(
            ...$value
                ->split(',')
                ->foreach(static function(Str $accept): void {
                    if (!$accept->matches(self::PATTERN)) {
                        throw new DomainException;
                    }
                })
                ->reduce(
                    new Set(Value::class),
                    static function(Set $carry, Str $accept): Set {
                        $matches = $accept->capture(self::PATTERN);

                        return $carry->add(new AcceptEncodingValue(
                            (string) $matches->get('coding'),
                            new Quality(
                                $matches->contains('quality') ?
                                    (float) (string) $matches->get('quality') : 1
                            )
                        ));
                    }
                )
        );
    }
}
