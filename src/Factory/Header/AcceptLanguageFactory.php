<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\AcceptLanguageValue,
    Header\AcceptLanguage,
    Header\Parameter\Quality,
    Exception\DomainException
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
            throw new DomainException;
        }

        $values = new Set(Value::class);

        foreach ($value->split(',') as $accept) {
            if (!$accept->matches(self::PATTERN)) {
                throw new DomainException;
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

        return new AcceptLanguage(...$values);
    }
}
