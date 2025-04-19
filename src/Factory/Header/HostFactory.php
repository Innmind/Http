<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\Header\Host;
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 */
final class HostFactory implements Implementation
{
    #[\Override]
    public function __invoke(Str $value): Maybe
    {
        return Url::maybe('http://'.$value->toString())->map(static fn($url) => Host::of(
            $url->authority()->host(),
            $url->authority()->port(),
        ));
    }
}
