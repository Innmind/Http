<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\Authority\{
    Host as UrlHost,
    PortInterface,
};

final class Host extends Header
{
    public function __construct(HostValue $host)
    {
        parent::__construct('Host', $host);
    }

    public static function of(UrlHost $host, PortInterface $port): self
    {
        return new self(new HostValue($host, $port));
    }
}
