<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\HeaderValueInterface,
    Header\AcceptLanguageValue,
    Header\AcceptLanguage,
    Header\Quality
};
use Innmind\Immutable\{
    StringPrimitive as Str,
    Set
};

final class AcceptLanguageFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        $values = new Set(HeaderValueInterface::class);

        foreach ($value->split(',') as $accept) {
            $matches = $accept->getMatches(
                '~(?<lang>([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~'
            );

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
