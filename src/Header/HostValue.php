<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\Authority\{
    Host as UrlHost,
    Port,
};

final class HostValue extends Value\Value
{
    private UrlHost $host;
    private Port $port;

    public function __construct(UrlHost $host, Port $port)
    {
        $this->host = $host;
        $this->port = $port;

        parent::__construct($host->toString().$port->format());
    }

    public function host(): UrlHost
    {
        return $this->host;
    }

    public function port(): Port
    {
        return $this->port;
    }
}
