<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class AcceptCharset implements Custom
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
    public function normalize(): Header
    {
        return $this->header;
    }
}
