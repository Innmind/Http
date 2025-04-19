<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class Link implements Provider
{
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(LinkValue ...$values)
    {
        $this->header = new Header('Link', ...$values);
    }

    #[\Override]
    public function toHeader(): Header
    {
        return $this->header;
    }
}
