<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class AcceptCharset implements Provider
{
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(AcceptCharsetValue ...$values)
    {
        $this->header = new Header('Accept-Charset', ...$values);
    }

    #[\Override]
    public function toHeader(): Header
    {
        return $this->header;
    }
}
