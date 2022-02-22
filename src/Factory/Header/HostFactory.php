<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\Host,
};
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class HostFactory implements HeaderFactory
{
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'host') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Maybe<Header> */
        return Url::maybe('http://'.$value->toString())->map(static fn($url) => Host::of(
            $url->authority()->host(),
            $url->authority()->port(),
        ));
    }
}
