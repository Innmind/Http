<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Cookie,
    Header\CookieValue,
    Header\Parameter\Parameter,
    Exception\DomainException,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class CookieFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~^(\w+=\"?[\w\-.]*\"?)?(; ?\w+=\"?[\w\-.]*\"?)*$~';

    public function __invoke(Str $name, Str $value): Header
    {
        if (
            $name->toLower()->toString() !== 'cookie' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new DomainException($name->toString());
        }

        return new Cookie(
            new CookieValue(
                ...$this->buildParams($value),
            ),
        );
    }

    /**
     * @return list<Parameter>
     */
    private function buildParams(Str $params): array
    {
        /** @var list<Parameter> */
        return $params
            ->split(';')
            ->map(static function(Str $value): Str {
                return $value->trim();
            })
            ->filter(static function(Str $value): bool {
                return !$value->empty();
            })
            ->reduce(
                [],
                static function(array $carry, Str $value): array {
                    $matches = $value->capture('~^(?<key>\w+)=\"?(?<value>[\w\-.]*)\"?$~');
                    $carry[] = Maybe::all($matches->get('key'), $matches->get('value'))
                        ->map(static fn(Str $key, Str $value) => new Parameter(
                            $key->toString(),
                            $value->toString(),
                        ))
                        ->match(
                            static fn($parameter) => $parameter,
                            static fn() => throw new DomainException,
                        );

                    return $carry;
                },
            );
    }
}
