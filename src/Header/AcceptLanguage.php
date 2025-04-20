<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class AcceptLanguage implements Custom
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
    public function normalize(): Header
    {
        return $this->header;
    }
}
