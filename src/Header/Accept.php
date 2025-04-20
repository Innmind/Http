<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class Accept implements Custom
{
    private Header $header;

    public function __construct(AcceptValue $first, AcceptValue ...$values)
    {
        $this->header = new Header('Accept', $first, ...$values);
    }

    #[\Override]
    public function normalize(): Header
    {
        return $this->header;
    }
}
