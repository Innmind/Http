<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class Host extends Header
{
    public function __construct(HostValue $host)
    {
        parent::__construct('Host', $host);
    }
}
