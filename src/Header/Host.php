<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;
use Innmind\Url\Authority\{
    Host as UrlHost,
    Port,
};

/**
 * @psalm-immutable
 */
final class Host implements Custom
{
    private function __construct(
        private UrlHost $host,
        private Port $port,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(UrlHost $host, Port $port): self
    {
        return new self($host, $port);
    }

    public function host(): UrlHost
    {
        return $this->host;
    }

    public function port(): Port
    {
        return $this->port;
    }

    #[\Override]
    public function normalize(): Header
    {
        return Header::of(
            'Host',
            new Value(
                $this->host->toString().$this->port->format(),
            ),
        );
    }
}
