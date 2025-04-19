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
    Sequence,
    Predicate\Instance,
};

/**
 * @psalm-immutable
 */
final class CacheControlFactory implements HeaderFactory
{
    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'cache-control') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Sequence<CacheControlValue> */
        $values = Sequence::of();

        return $value
            ->split(',')
            ->map(static fn($split) => $split->trim())
            ->map(static fn($split) => match (true) {
                $split->matches('~^max-age=\d+$~') => Maybe::just($split->substring(8)->toString())
                    ->filter(\is_numeric(...))
                    ->map(static fn($age) => (int) $age)
                    ->flatMap(static fn($age) => CacheControlValue\MaxAge::of($age)),
                $split->matches('~^max-stale(=\d+)?$~') => Maybe::just($split)
                    ->filter(static fn($split) => $split->length() > 10)
                    ->map(static fn($split) => $split->substring(10)->toString())
                    ->filter(\is_numeric(...))
                    ->map(static fn($age) => (int) $age)
                    ->otherwise(static fn() => Maybe::just(0))
                    ->flatMap(CacheControlValue\MaxStale::of(...)),
                $split->matches('~^min-fresh=\d+$~') => Maybe::just($split->substring(10)->toString())
                    ->filter(\is_numeric(...))
                    ->map(static fn($age) => (int) $age)
                    ->flatMap(CacheControlValue\MinimumFresh::of(...)),
                $split->toString() === 'must-revalidate' => Maybe::just(new CacheControlValue\MustRevalidate),
                $split->matches('~^no-cache(="?\w+"?)?$~') => $split
                    ->capture('~^no-cache(="?(?<field>\w+)"?)?$~')
                    ->get('field')
                    ->map(static fn($field) => $field->toString())
                    ->otherwise(static fn() => Maybe::just(''))
                    ->flatMap(CacheControlValue\NoCache::of(...)),
                $split->toString() === 'no-store' => Maybe::just(new CacheControlValue\NoStore),
                $split->toString() === 'immutable' => Maybe::just(new CacheControlValue\Immutable),
                $split->toString() === 'no-transform' => Maybe::just(new CacheControlValue\NoTransform),
                $split->toString() === 'only-if-cached' => Maybe::just(new CacheControlValue\OnlyIfCached),
                $split->matches('~^private(="?\w+"?)?$~') => $split
                    ->capture('~^private(="?(?<field>\w+)"?)?$~')
                    ->get('field')
                    ->map(static fn($field) => $field->toString())
                    ->otherwise(static fn() => Maybe::just(''))
                    ->flatMap(CacheControlValue\PrivateCache::of(...)),
                $split->toString() === 'proxy-revalidate' => Maybe::just(new CacheControlValue\ProxyRevalidate),
                $split->toString() === 'public' => Maybe::just(new CacheControlValue\PublicCache),
                $split->matches('~^s-maxage=\d+$~') => Maybe::just($split->substring(9)->toString())
                    ->filter(\is_numeric(...))
                    ->map(static fn($age) => (int) $age)
                    ->flatMap(CacheControlValue\SharedMaxAge::of(...)),
                default => null,
            })
            ->keep(Instance::of(Maybe::class))
            ->sink($values)
            ->maybe(static fn($values, $value) => $value->map($values))
            ->map(static fn($values) => $values->match(
                static fn($first, $rest) => new CacheControl($first, ...$rest->toList()),
                static fn() => null,
            ))
            ->keep(Instance::of(CacheControl::class));
    }
}
