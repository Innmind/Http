<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class AcceptLanguage implements Provider
{
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(AcceptLanguageValue ...$values)
    {
        $this->header = new Header('Accept-Language', ...$values);
    }

    #[\Override]
    public function toHeader(): Header
    {
        return $this->header;
    }
}
