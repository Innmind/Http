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

        $splits = $value->split(',');
        $values = new Set(Value::class);

        foreach ($splits as $split) {
            $split = $split->trim();

            switch (true) {
                case $split->matches('~^max-age=\d+$~'):
                    $values = $values->add(
                        new CacheControlValue\MaxAge(
                            (int) (string) $split->substring(8)
                        )
                    );
                    break;
                case $split->matches('~^max-stale(=\d+)?$~'):
                    $values = $values->add(
                        new CacheControlValue\MaxStale(
                            $split->length() > 10 ?
                                (int) (string) $split->substring(10) : 0
                        )
                    );
                    break;
                case $split->matches('~^min-fresh=\d+$~'):
                    $values = $values->add(
                        new CacheControlValue\MinimumFresh(
                            (int) (string) $split->substring(10)
                        )
                    );
                    break;
                case (string) $split === 'must-revalidate':
                    $values = $values->add(new CacheControlValue\MustRevalidate);
                    break;
                case $split->matches('~^no-cache(="?\w+"?)?$~'):
                    $matches = $split->capture(
                        '~^no-cache(="?(?<field>\w+)"?)?$~'
                    );
                    $values = $values->add(
                        new CacheControlValue\NoCache(
                            $matches->contains('field') ?
                                (string) $matches->get('field') : ''
                        )
                    );
                    break;
                case (string) $split === 'no-store':
                    $values = $values->add(new CacheControlValue\NoStore);
                    break;
                case (string) $split === 'no-transform':
                    $values = $values->add(new CacheControlValue\NoTransform);
                    break;
                case (string) $split === 'only-if-cached':
                    $values = $values->add(new CacheControlValue\OnlyIfCached);
                    break;
                case $split->matches('~^private(="?\w+"?)?$~'):
                    $matches = $split->capture(
                        '~^private(="?(?<field>\w+)"?)?$~'
                    );
                    $values = $values->add(
                        new CacheControlValue\PrivateCache(
                            $matches->contains('field') ?
                                (string) $matches->get('field') : ''
                        )
                    );
                    break;
                case (string) $split === 'proxy-revalidate':
                    $values = $values->add(new CacheControlValue\ProxyRevalidate);
                    break;
                case (string) $split === 'public':
                    $values = $values->add(new CacheControlValue\PublicCache);
                    break;
                case $split->matches('~^s-maxage=\d+$~'):
                    $values = $values->add(
                        new CacheControlValue\SharedMaxAge(
                            (int) (string) $split->substring(9)
                        )
                    );
                    break;
            }
        }

        return new CacheControl(...$values);
    }
}
