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
    public function __construct(
        private HostValue $value,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(UrlHost $host, Port $port): self
    {
        return new self(new HostValue($host, $port));
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
        return $this->value->host();
    }

    public function port(): Port
    {
        return $this->value->port();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header('Host', $this->value);
    }
}
