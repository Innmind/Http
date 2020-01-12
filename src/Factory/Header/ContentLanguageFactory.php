<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\ContentLanguage,
    Header\ContentLanguageValue,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class ContentLanguageFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'content-language') {
            throw new DomainException;
        }

        return new ContentLanguage(
            ...$value
                ->split(',')
                ->reduce(
                    [],
                    static function(array $carry, Str $language): array {
                        $carry[] = new ContentLanguageValue(
                            $language->trim()->toString(),
                        );

                        return $carry;
                    },
                ),
        );
    }
}
