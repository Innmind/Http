<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\Authority\{
    Host as UrlHost,
    PortInterface,
    NullPort
};

final class HostValue extends Value\Value
{
    private $host;
    private $port;

    public function __construct(UrlHost $host, PortInterface $port)
    {
        $this->host = $host;
        $this->port = $port;

        parent::__construct($host.(!$port instanceof NullPort ? ':'.$port : ''));
    }

    public function host(): UrlHost
    {
        return $this->host;
    }

    public function port(): PortInterface
    {
        return $this->port;
    }
}
