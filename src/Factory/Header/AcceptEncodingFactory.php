<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\HeaderValue,
    Header\AcceptEncodingValue,
    Header\AcceptEncoding,
    Header\Parameter\Quality,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\{
    Str,
    Set
};

final class AcceptEncodingFactory implements HeaderFactoryInterface
{
    const PATTERN = '~(?<coding>(\w+|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~';

    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'accept-encoding') {
            throw new InvalidArgumentException;
        }

        $values = new Set(HeaderValue::class);

        foreach ($value->split(',') as $accept) {
            if (!$accept->matches(self::PATTERN)) {
                throw new InvalidArgumentException;
            }

            $matches = $accept->capture(self::PATTERN);

            $values = $values->add(
                new AcceptEncodingValue(
                    (string) $matches->get('coding'),
                    new Quality(
                        $matches->contains('quality') ?
                            (float) (string) $matches->get('quality') : 1
                    )
                )
            );
        }

        return new AcceptEncoding($values);
    }
}
