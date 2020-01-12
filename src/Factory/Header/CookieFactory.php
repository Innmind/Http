<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Cookie,
    Header\CookieValue,
    Header\Parameter\Parameter,
    Exception\DomainException
};
use Innmind\Immutable\Str;

final class CookieFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~^(\w+=\"?[\w\-.]*\"?)?(; ?\w+=\"?[\w\-.]*\"?)*$~';

    public function __invoke(Str $name, Str $value): Header
    {
        if (
            $name->toLower()->toString() !== 'cookie' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new DomainException;
        }

        return new Cookie(
            new CookieValue(
                ...$this->buildParams($value)
            )
        );
    }

    private function buildParams(Str $params): array
    {
        return $params
            ->split(';')
            ->map(static function(Str $value): Str {
                return $value->trim();
            })
            ->filter(static function(Str $value): bool {
                return $value->length() > 0;
            })
            ->reduce(
                [],
                static function(array $carry, Str $value): array {
                    $matches = $value->capture('~^(?<key>\w+)=\"?(?<value>[\w\-.]*)\"?$~');
                    $carry[] = new Parameter(
                        $matches->get('key')->toString(),
                        $matches->get('value')->toString(),
                    );

                    return $carry;
                }
            );
    }
}
