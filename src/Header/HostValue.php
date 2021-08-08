<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\Authority\{
    Host as UrlHost,
    Port,
};

/**
 * @psalm-immutable
 */
final class HostValue implements Value
{
    private UrlHost $host;
    private Port $port;

    public function __construct(UrlHost $host, Port $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function host(): UrlHost
    {
        return $this->host;
    }

    public function port(): Port
    {
        return $this->port;
    }

    public function toString(): string
    {
        return $this->host->toString().$this->port->format();
    }
}
