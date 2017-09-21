<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\HeaderValue,
    Header\AcceptLanguageValue,
    Header\AcceptLanguage,
    Header\Parameter\Quality,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\{
    Str,
    Set
};

final class AcceptLanguageFactory implements HeaderFactoryInterface
{
    const PATTERN = '~(?<lang>([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~';

    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'accept-language') {
            throw new InvalidArgumentException;
        }

        $values = new Set(HeaderValue::class);

        foreach ($value->split(',') as $accept) {
            if (!$accept->matches(self::PATTERN)) {
                throw new InvalidArgumentException;
            }

            $matches = $accept->capture(self::PATTERN);

            $values = $values->add(
                new AcceptLanguageValue(
                    (string) $matches->get('lang'),
                    new Quality(
                        $matches->contains('quality') ?
                            (float) (string) $matches->get('quality') : 1
                    )
                )
            );
        }

        return new AcceptLanguage($values);
    }
}
