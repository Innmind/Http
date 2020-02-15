<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @extends Header<AcceptLanguageValue>
 */
final class AcceptLanguage extends Header
{
    public function __construct(AcceptLanguageValue ...$values)
    {
        parent::__construct('Accept-Language', ...$values);
    }
}
