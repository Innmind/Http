<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\CacheControlValue,
    Header\CacheControl,
    Exception\DomainException
};
use Innmind\Immutable\{
    Str,
    Set
};

final class CacheControlFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'cache-control') {
            throw new DomainException;
        }

        return new CacheControl(
            ...$value
                ->split(',')
                ->reduce(
                    new Set(Value::class),
                    static function(Set $carry, Str $split): Set {
                        $split = $split->trim();

                        switch (true) {
                            case $split->matches('~^max-age=\d+$~'):
                                return $carry->add(new CacheControlValue\MaxAge(
                                    (int) (string) $split->substring(8)
                                ));

                            case $split->matches('~^max-stale(=\d+)?$~'):
                                return $carry->add(new CacheControlValue\MaxStale(
                                    $split->length() > 10 ?
                                        (int) (string) $split->substring(10) : 0
                                ));

                            case $split->matches('~^min-fresh=\d+$~'):
                                return $carry->add(new CacheControlValue\MinimumFresh(
                                    (int) (string) $split->substring(10)
                                ));

                            case (string) $split === 'must-revalidate':
                                return $carry->add(new CacheControlValue\MustRevalidate);

                            case $split->matches('~^no-cache(="?\w+"?)?$~'):
                                $matches = $split->capture(
                                    '~^no-cache(="?(?<field>\w+)"?)?$~'
                                );

                                return $carry->add(new CacheControlValue\NoCache(
                                    $matches->contains('field') ?
                                        (string) $matches->get('field') : ''
                                ));

                            case (string) $split === 'no-store':
                                return $carry->add(new CacheControlValue\NoStore);

                            case (string) $split === 'immutable':
                                return $carry->add(new CacheControlValue\Immutable);

                            case (string) $split === 'no-transform':
                                return $carry->add(new CacheControlValue\NoTransform);

                            case (string) $split === 'only-if-cached':
                                return $carry->add(new CacheControlValue\OnlyIfCached);

                            case $split->matches('~^private(="?\w+"?)?$~'):
                                $matches = $split->capture(
                                    '~^private(="?(?<field>\w+)"?)?$~'
                                );

                                return $carry->add(new CacheControlValue\PrivateCache(
                                    $matches->contains('field') ?
                                        (string) $matches->get('field') : ''
                                ));

                            case (string) $split === 'proxy-revalidate':
                                return $carry->add(new CacheControlValue\ProxyRevalidate);

                            case (string) $split === 'public':
                                return $carry->add(new CacheControlValue\PublicCache);

                            case $split->matches('~^s-maxage=\d+$~'):
                                return $carry->add(new CacheControlValue\SharedMaxAge(
                                    (int) (string) $split->substring(9)
                                ));
                        }
                    }
                )
        );
    }
}
