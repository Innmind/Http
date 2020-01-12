<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\CacheControlValue,
    Header\CacheControl,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class CacheControlFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'cache-control') {
            throw new DomainException($name->toString());
        }

        return new CacheControl(
            ...$value
                ->split(',')
                ->reduce(
                    [],
                    static function(array $carry, Str $split): array {
                        $split = $split->trim();

                        switch (true) {
                            case $split->matches('~^max-age=\d+$~'):
                                $carry[] = new CacheControlValue\MaxAge(
                                    (int) $split->substring(8)->toString(),
                                );
                                break;

                            case $split->matches('~^max-stale(=\d+)?$~'):
                                $carry[] = new CacheControlValue\MaxStale(
                                    $split->length() > 10 ?
                                        (int) $split->substring(10)->toString() : 0,
                                );
                                break;

                            case $split->matches('~^min-fresh=\d+$~'):
                                $carry[] = new CacheControlValue\MinimumFresh(
                                    (int) $split->substring(10)->toString(),
                                );
                                break;

                            case $split->toString() === 'must-revalidate':
                                $carry[] = new CacheControlValue\MustRevalidate;
                                break;

                            case $split->matches('~^no-cache(="?\w+"?)?$~'):
                                $matches = $split->capture(
                                    '~^no-cache(="?(?<field>\w+)"?)?$~',
                                );

                                $carry[] = new CacheControlValue\NoCache(
                                    $matches->contains('field') ?
                                        $matches->get('field')->toString() : '',
                                );
                                break;

                            case $split->toString() === 'no-store':
                                $carry[] = new CacheControlValue\NoStore;
                                break;

                            case $split->toString() === 'immutable':
                                $carry[] = new CacheControlValue\Immutable;
                                break;

                            case $split->toString() === 'no-transform':
                                $carry[] = new CacheControlValue\NoTransform;
                                break;

                            case $split->toString() === 'only-if-cached':
                                $carry[] = new CacheControlValue\OnlyIfCached;
                                break;

                            case $split->matches('~^private(="?\w+"?)?$~'):
                                $matches = $split->capture(
                                    '~^private(="?(?<field>\w+)"?)?$~',
                                );

                                $carry[] = new CacheControlValue\PrivateCache(
                                    $matches->contains('field') ?
                                        $matches->get('field')->toString() : '',
                                );
                                break;

                            case $split->toString() === 'proxy-revalidate':
                                $carry[] = new CacheControlValue\ProxyRevalidate;
                                break;

                            case $split->toString() === 'public':
                                $carry[] = new CacheControlValue\PublicCache;
                                break;

                            case $split->matches('~^s-maxage=\d+$~'):
                                $carry[] = new CacheControlValue\SharedMaxAge(
                                    (int) $split->substring(9)->toString(),
                                );
                                break;
                        }

                        return $carry;
                    },
                ),
        );
    }
}
