<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Url\Authority\{
    Host as UrlHost,
    Port,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Host implements HeaderInterface
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

    #[\Override]
    public function name(): string
    {
        return $this->header()->name();
    }

    #[\Override]
    public function values(): Sequence
    {
        return $this->header()->values();
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
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header(
            'Host',
            new Value\Value(
                $this->host->toString().$this->port->format(),
            ),
        );
    }
}
