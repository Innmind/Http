<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\HeaderValueInterface,
    Header\ContentLanguage,
    Header\ContentLanguageValue
};
use Innmind\Immutable\{
    StringPrimitive as Str,
    Set
};

final class ContentLanguageFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        $values = new Set(HeaderValueInterface::class);

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
