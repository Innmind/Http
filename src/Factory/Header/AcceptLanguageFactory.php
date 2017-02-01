<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\HeaderValueInterface,
    Header\AcceptLanguageValue,
    Header\AcceptLanguage,
    Header\Quality,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\{
    StringPrimitive as Str,
    Set
};

final class AcceptLanguageFactory implements HeaderFactoryInterface
{
    const PATTERN = '~(?<lang>([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~';

    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'accept-language') {
            throw new InvalidArgumentException;
        }

        $values = new Set(HeaderValueInterface::class);

        foreach ($value->split(',') as $accept) {
            if (!$accept->match(self::PATTERN)) {
                throw new InvalidArgumentException;
            }

            $matches = $accept->getMatches(self::PATTERN);

            $values = $values->add(
                new AcceptLanguageValue(
                    (string) $matches->get('lang'),
                    new Quality(
                        $matches->hasKey('quality') ?
                            (float) (string) $matches->get('quality') : 1
                    )
                )
            );
        }

        return new AcceptLanguage($values);
    }
}
