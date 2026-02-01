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
    #[\NoDiscard]
    public static function of(UrlHost $host, Port $port): self
    {
        return new self($host, $port);
    }

    #[\NoDiscard]
    public function host(): UrlHost
    {
        return $this->host;
    }

    #[\NoDiscard]
    public function port(): Port
    {
        return $this->port;
    }

    #[\Override]
    #[\NoDiscard]
    public function normalize(): Header
    {
        return Header::of(
            'Host',
            Value::of(
                $this->host->toString().$this->port->format(),
            ),
        );
    }
}
