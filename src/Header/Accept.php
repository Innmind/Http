<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class Accept implements Provider
{
    private Header $header;

    public function __construct(AcceptValue $first, AcceptValue ...$values)
    {
        $this->header = new Header('Accept', $first, ...$values);
    }

    #[\Override]
    public function toHeader(): Header
    {
        return $this->header;
    }
}
