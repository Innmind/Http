<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\HeaderValueInterface,
    Header\AcceptEncodingValue,
    Header\AcceptEncoding,
    Header\Quality,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\{
    StringPrimitive as Str,
    Set
};

final class AcceptEncodingFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'accept-encoding') {
            throw new InvalidArgumentException;
        }

        $values = new Set(HeaderValueInterface::class);

        foreach ($value->split(',') as $accept) {
            $matches = $accept->getMatches(
                '~(?<coding>(\w+|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~'
            );

            $values = $values->add(
                new AcceptEncodingValue(
                    (string) $matches->get('coding'),
                    new Quality(
                        $matches->hasKey('quality') ?
                            (float) (string) $matches->get('quality') : 1
                    )
                )
            );
        }

        return new AcceptEncoding($values);
    }
}
