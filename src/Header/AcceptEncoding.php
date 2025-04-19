<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class AcceptEncoding implements Provider
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
    public function toHeader(): Header
    {
        return $this->header;
    }
}
