<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Url\Authority\{
    Host as UrlHost,
    Port,
};

/**
 * @extends Header<HostValue>
 * @implements HeaderInterface<HostValue>
 * @psalm-immutable
 */
final class Host extends Header implements HeaderInterface
{
    public function __construct(HostValue $host)
    {
        parent::__construct('Host', $host);
    }

    public static function of(UrlHost $host, Port $port): self
    {
        return new self(new HostValue($host, $port));
    }
}
