<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\{
    SetInterface,
    Set
};

final class AcceptLanguage extends Header
{
    public function __construct(SetInterface $values = null)
    {
        $values = $values ?? new Set(HeaderValueInterface::class);

        $values->foreach(function(HeaderValueInterface $value) {
            if (!$value instanceof AcceptLanguageValue) {
                throw new InvalidArgumentException;
            }
        });

        parent::__construct('Accept-Language', $values);
    }
}
