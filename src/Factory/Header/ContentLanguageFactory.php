<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\ContentLanguage,
    Header\ContentLanguageValue,
    Exception\DomainException
};
use Innmind\Immutable\{
    Str,
    Set
};

final class ContentLanguageFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'content-language') {
            throw new DomainException;
        }

        return new ContentLanguage(
            ...$value
                ->split(',')
                ->reduce(
                    new Set(Value::class),
                    static function(Set $carry, Str $language): Set {
                        return $carry->add(new ContentLanguageValue(
                            (string) $language->trim()
                        ));
                    }
                )
        );
    }
}
