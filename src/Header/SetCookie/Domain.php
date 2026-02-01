<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\SetCookie;

use Innmind\Http\Header\Parameter;
use Innmind\Url\Authority\Host;

/**
 * @psalm-immutable
 */
final class Domain
{
    private function __construct(
        private Host $host,
    ) {
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(Host $host): self
    {
        return new self($host);
    }

    #[\NoDiscard]
    public function host(): Host
    {
        return $this->host;
    }

    #[\NoDiscard]
    public function toParameter(): Parameter
    {
        return Parameter::of('Domain', $this->host->toString());
    }
}
