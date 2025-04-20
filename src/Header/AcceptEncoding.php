<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class AcceptEncoding implements Custom
{
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(AcceptEncodingValue ...$values)
    {
        $this->header = new Header('Accept-Encoding', ...$values);
    }

    #[\Override]
    public function normalize(): Header
    {
        return $this->header;
    }
}
