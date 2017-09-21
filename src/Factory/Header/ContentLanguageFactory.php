<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\HeaderValue,
    Header\ContentLanguage,
    Header\ContentLanguageValue,
    Exception\InvalidArgumentException
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
            throw new InvalidArgumentException;
        }

        $values = new Set(HeaderValue::class);

        foreach ($value->split(',') as $language) {
            $values = $values->add(
                new ContentLanguageValue(
                    (string) $language->trim()
                )
            );
        }

        return new ContentLanguage($values);
    }
}
