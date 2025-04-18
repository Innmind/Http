<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\Cookie,
    Header\Parameter\Parameter,
};
use Innmind\Immutable\{
    Str,
    Maybe,
    Sequence,
};

/**
 * @psalm-immutable
 */
final class CookieFactory implements HeaderFactory
{
    private const PATTERN = '~^(\w+=\"?[\w\-.]*\"?)?(; ?\w+=\"?[\w\-.]*\"?)*$~';

    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if (
            $name->toLower()->toString() !== 'cookie' ||
            !$value->matches(self::PATTERN)
        ) {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        $values = $this->buildParams($value);

        if ($values->empty()) {
            /** @var Maybe<Header> */
            return Maybe::just(Cookie::of());
        }

        /**
         * @psalm-suppress NamedArgumentNotAllowed
         * @psalm-suppress InvalidArgument
         * @var Maybe<Header>
         */
        return Maybe::all(...$values->toList())->map(
            static fn(Parameter ...$params) => Cookie::of(...$params),
        );
    }

    /**
     * @return Sequence<Maybe<Parameter>>
     */
    private function buildParams(Str $params): Sequence
    {
        return $params
            ->split(';')
            ->map(static fn($value) => $value->trim())
            ->filter(static fn($value) => !$value->empty())
            ->map(static function(Str $value) {
                $matches = $value->capture('~^(?<key>\w+)=\"?(?<value>[\w\-.]*)\"?$~');

                return Maybe::all($matches->get('key'), $matches->get('value'))
                    ->map(static fn(Str $key, Str $value) => new Parameter(
                        $key->toString(),
                        $value->toString(),
                    ));
            });
    }
}
