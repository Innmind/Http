<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<AcceptLanguageValue>
 * @implements HeaderInterface<AcceptLanguageValue>
 * @psalm-immutable
 */
final class AcceptLanguage extends Header implements HeaderInterface
{
    public function __construct(AcceptLanguageValue ...$values)
    {
        parent::__construct('Accept-Language', ...$values);
    }
}
