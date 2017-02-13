<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\HeaderValueInterface,
    Header\AcceptCharsetValue,
    Header\AcceptCharset,
    Header\Quality,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\{
    Str,
    Set
};

final class AcceptCharsetFactory implements HeaderFactoryInterface
{
    const PATTERN = '~(?<charset>[a-zA-Z0-9\-_:\(\)]+)(; ?q=(?<quality>\d+(\.\d+)?))?~';

    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'accept-charset') {
            throw new InvalidArgumentException;
        }

        $values = new Set(HeaderValueInterface::class);

        foreach ($value->split(',') as $accept) {
            if (!$accept->matches(self::PATTERN)) {
                throw new InvalidArgumentException;
            }

            $matches = $accept->getMatches(self::PATTERN);

            $values = $values->add(
                new AcceptCharsetValue(
                    (string) $matches->get('charset'),
                    new Quality(
                        $matches->contains('quality') ?
                            (float) (string) $matches->get('quality') : 1
                    )
                )
            );
        }

        return new AcceptCharset($values);
    }
}
