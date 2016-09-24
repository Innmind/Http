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
    StringPrimitive as Str,
    Set
};

final class AcceptCharsetFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'accept-charset') {
            throw new InvalidArgumentException;
        }

        $values = new Set(HeaderValueInterface::class);

        foreach ($value->split(',') as $accept) {
            $matches = $accept->getMatches(
                '~(?<charset>[a-zA-Z0-9\-_:\(\)]+)(; ?q=(?<quality>\d+(\.\d+)?))?~'
            );

            $values = $values->add(
                new AcceptCharsetValue(
                    (string) $matches->get('charset'),
                    new Quality(
                        $matches->hasKey('quality') ?
                            (float) (string) $matches->get('quality') : 1
                    )
                )
            );
        }

        return new AcceptCharset($values);
    }
}
