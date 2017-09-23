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
    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'content-language') {
            throw new DomainException;
        }

        $values = new Set(Value::class);

        foreach ($value->split(',') as $language) {
            $values = $values->add(
                new ContentLanguageValue(
                    (string) $language->trim()
                )
            );
        }

        return new ContentLanguage(...$values);
    }
}
