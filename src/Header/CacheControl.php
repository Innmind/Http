<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\{
    InvalidArgumentException,
    CacheControlHeaderMustContainAtLeastOneValue
};
use Innmind\Immutable\SetInterface;

final class CacheControl extends Header
{
    public function __construct(SetInterface $values)
    {
        if ($values->size() === 0) {
            throw new CacheControlHeaderMustContainAtLeastOneValue;
        }

        $values->foreach(function(Value $header) {
            if (!$header instanceof CacheControlValue) {
                throw new InvalidArgumentException;
            }
        });

        parent::__construct('Cache-Control', $values);
    }
}
