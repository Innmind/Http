<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class WWWAuthenticate implements Provider
{
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(WWWAuthenticateValue ...$values)
    {
        $this->header = new Header('WWW-Authenticate', ...$values);
    }

    #[\Override]
    public function toHeader(): Header
    {
        return $this->header;
    }
}
