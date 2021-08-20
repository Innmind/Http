<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\CacheControlValue,
    Header\CacheControl,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class CacheControlFactory implements HeaderFactory
{
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'cache-control') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var list<CacheControlValue> */
        $values = $value
            ->split(',')
            ->map(static fn($split) => $split->trim())
            ->map(static fn($split) => match (true) {
                $split->matches('~^max-age=\d+$~') => new CacheControlValue\MaxAge(
                    (int) $split->substring(8)->toString(),
                ),
                $split->matches('~^max-stale(=\d+)?$~') => new CacheControlValue\MaxStale(
                    $split->length() > 10 ?
                        (int) $split->substring(10)->toString() : 0,
                ),
                $split->matches('~^min-fresh=\d+$~') => new CacheControlValue\MinimumFresh(
                    (int) $split->substring(10)->toString(),
                ),
                $split->toString() === 'must-revalidate' => new CacheControlValue\MustRevalidate,
                $split->matches('~^no-cache(="?\w+"?)?$~') => new CacheControlValue\NoCache(
                    $split
                        ->capture('~^no-cache(="?(?<field>\w+)"?)?$~')
                        ->get('field')
                        ->match(
                            static fn($field) => $field->toString(),
                            static fn() => '',
                        ),
                ),
                $split->toString() === 'no-store' => new CacheControlValue\NoStore,
                $split->toString() === 'immutable' => new CacheControlValue\Immutable,
                $split->toString() === 'no-transform' => new CacheControlValue\NoTransform,
                $split->toString() === 'only-if-cached' => new CacheControlValue\OnlyIfCached,
                $split->matches('~^private(="?\w+"?)?$~') => new CacheControlValue\PrivateCache(
                    $split
                        ->capture('~^private(="?(?<field>\w+)"?)?$~')
                        ->get('field')
                        ->match(
                            static fn($field) => $field->toString(),
                            static fn() => '',
                        ),
                ),
                $split->toString() === 'proxy-revalidate' => new CacheControlValue\ProxyRevalidate,
                $split->toString() === 'public' => new CacheControlValue\PublicCache,
                $split->matches('~^s-maxage=\d+$~') => new CacheControlValue\SharedMaxAge(
                    (int) $split->substring(9)->toString(),
                ),
                default => null,
            })
            ->filter(static fn($value) => $value instanceof CacheControlValue)
            ->toList();

        /** @var Maybe<Header> */
        return Maybe::just(new CacheControl(...$values));
    }
}
