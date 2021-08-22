<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\Value,
    Header\AcceptValue,
    Header\Accept,
    Header\Parameter,
};
use Innmind\Immutable\{
    Str,
    Maybe,
    Sequence,
};

final class AcceptFactory implements HeaderFactory
{
    private const PATTERN = '~(?<type>[\w*]+)/(?<subType>[\w*]+)(?<params>(; ?\w+=\"?[\w\-.]+\"?)+)?~';

    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'accept') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        $values = $value
            ->split(',')
            ->map(function(Str $accept) {
                $matches = $accept->capture(self::PATTERN);
                $params = $this->buildParams($matches->get('params')->match(
                    static fn($params) => $params,
                    static fn() => Str::of(''),
                ));

                /**
                 * @psalm-suppress MixedArgument Because $params can't be typed in the closure
                 */
                return Maybe::all(
                    $matches->get('type'),
                    $matches->get('subType'),
                    $params,
                )->flatMap(static fn(Str $type, Str $subType, array $params) => AcceptValue::of(
                    $type->toString(),
                    $subType->toString(),
                    ...$params,
                ));
            });

        if ($values->empty()) {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /**
         * @psalm-suppress NamedArgumentNotAllowed
         * @var Maybe<Header>
         */
        return Maybe::all(...$values->toList())->map(
            static fn(AcceptValue ...$values) => new Accept(...$values),
        );
    }

    /**
     * @return Maybe<list<Parameter>>
     */
    private function buildParams(Str $params): Maybe
    {
        $params = $params
            ->split(';')
            ->filter(static function(Str $value): bool {
                return !$value->trim()->empty();
            })
            ->map(static function(Str $value) {
                $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[\w\-.]+)\"?~');

                return Maybe::all($matches->get('key'), $matches->get('value'))
                    ->map(static fn(Str $key, Str $value) => new Parameter\Parameter(
                        $key->toString(),
                        $value->toString(),
                    ));
            });

        if ($params->empty()) {
            /** @var Maybe<list<Parameter>> */
            return Maybe::just([]);
        }

        /** @var Maybe<list<Parameter>> */
        return Maybe::all(...$params->toList())->map(
            static fn(Parameter ...$params) => $params,
        );
    }
}
