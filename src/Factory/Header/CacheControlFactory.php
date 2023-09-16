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
};

/**
 * @psalm-immutable
 */
final class CacheControlFactory implements HeaderFactory
{
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'cache-control') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Sequence<Maybe<CacheControlValue>> */
        $values = $value
            ->split(',')
            ->map(static fn($split) => $split->trim())
            ->map(static fn($split) => match (true) {
                $split->matches('~^max-age=\d+$~') => Maybe::just($split->substring(8)->toString())
                    ->filter(static fn($age) => \is_numeric($age))
                    ->map(static fn($age) => (int) $age)
                    ->flatMap(static fn($age) => CacheControlValue\MaxAge::of($age)),
                $split->matches('~^max-stale(=\d+)?$~') => Maybe::just($split)
                    ->filter(static fn($split) => $split->length() > 10)
                    ->map(static fn($split) => $split->substring(10)->toString())
                    ->filter(static fn($age) => \is_numeric($age))
                    ->map(static fn($age) => (int) $age)
                    ->otherwise(static fn() => Maybe::just(0))
                    ->flatMap(static fn($age) => CacheControlValue\MaxStale::of($age)),
                $split->matches('~^min-fresh=\d+$~') => Maybe::just($split->substring(10)->toString())
                    ->filter(static fn($age) => \is_numeric($age))
                    ->map(static fn($age) => (int) $age)
                    ->flatMap(static fn($age) => CacheControlValue\MinimumFresh::of($age)),
                $split->toString() === 'must-revalidate' => Maybe::just(new CacheControlValue\MustRevalidate),
                $split->matches('~^no-cache(="?\w+"?)?$~') => $split
                    ->capture('~^no-cache(="?(?<field>\w+)"?)?$~')
                    ->get('field')
                    ->map(static fn($field) => $field->toString())
                    ->otherwise(static fn() => Maybe::just(''))
                    ->flatMap(static fn($field) => CacheControlValue\NoCache::of($field)),
                $split->toString() === 'no-store' => Maybe::just(new CacheControlValue\NoStore),
                $split->toString() === 'immutable' => Maybe::just(new CacheControlValue\Immutable),
                $split->toString() === 'no-transform' => Maybe::just(new CacheControlValue\NoTransform),
                $split->toString() === 'only-if-cached' => Maybe::just(new CacheControlValue\OnlyIfCached),
                $split->matches('~^private(="?\w+"?)?$~') => $split
                    ->capture('~^private(="?(?<field>\w+)"?)?$~')
                    ->get('field')
                    ->map(static fn($field) => $field->toString())
                    ->otherwise(static fn() => Maybe::just(''))
                    ->flatMap(static fn($field) => CacheControlValue\PrivateCache::of($field)),
                $split->toString() === 'proxy-revalidate' => Maybe::just(new CacheControlValue\ProxyRevalidate),
                $split->toString() === 'public' => Maybe::just(new CacheControlValue\PublicCache),
                $split->matches('~^s-maxage=\d+$~') => Maybe::just($split->substring(9)->toString())
                    ->filter(static fn($age) => \is_numeric($age))
                    ->map(static fn($age) => (int) $age)
                    ->flatMap(static fn($age) => CacheControlValue\SharedMaxAge::of($age)),
                default => null,
            })
            ->filter(static fn($value) => $value instanceof Maybe);

        if ($values->empty()) {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /**
         * @psalm-suppress InvalidArgument
         * @var Maybe<Header>
         */
        return Maybe::all(...$values->toList())->map(
            static fn(CacheControlValue ...$values) => new CacheControl(...$values),
        );
    }
}
