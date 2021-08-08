<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\AcceptValue,
    Header\Accept,
    Header\Parameter,
    Exception\DomainException,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class AcceptFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~(?<type>[\w*]+)/(?<subType>[\w*]+)(?<params>(; ?\w+=\"?[\w\-.]+\"?)+)?~';

    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'accept') {
            throw new DomainException($name->toString());
        }

        $values = $value->split(',');
        $_ = $values->foreach(static function(Str $accept): void {
            if (!$accept->matches(self::PATTERN)) {
                throw new DomainException($accept->toString());
            }
        });

        /** @var list<AcceptValue> */
        $values = $values->reduce(
            [],
            function(array $carry, Str $accept): array {
                $matches = $accept->capture(self::PATTERN);
                $carry[] = Maybe::all($matches->get('type'), $matches->get('subType'))
                    ->map(fn(Str $type, Str $subType) => new AcceptValue(
                        $type->toString(),
                        $subType->toString(),
                        ...$this->buildParams(
                            $matches->get('params')->match(
                                static fn($params) => $params,
                                static fn() => Str::of(''),
                            ),
                        ),
                    ))
                    ->match(
                        static fn($value) => $value,
                        static fn() => throw new DomainException,
                    );

                return $carry;
            },
        );

        return new Accept(...$values);
    }

    /**
     * @return list<Parameter>
     */
    private function buildParams(Str $params): array
    {
        /** @var list<Parameter> */
        return $params
            ->split(';')
            ->filter(static function(Str $value): bool {
                return !$value->trim()->empty();
            })
            ->reduce(
                [],
                static function(array $carry, Str $value): array {
                    $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[\w\-.]+)\"?~');
                    $carry[] = Maybe::all($matches->get('key'), $matches->get('value'))
                        ->map(static fn(Str $key, Str $value) => new Parameter\Parameter(
                            $key->toString(),
                            $value->toString(),
                        ))
                        ->match(
                            static fn($param) => $param,
                            static fn() => throw new DomainException,
                        );

                    return $carry;
                }
            );
    }
}
