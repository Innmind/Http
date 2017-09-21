<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\{
    InvalidArgumentException,
    AcceptHeaderMustContainAtLeastOneValue
};
use Innmind\Immutable\SetInterface;

final class Accept extends Header
{
    public function __construct(SetInterface $values)
    {
        if ($values->size() === 0) {
            throw new AcceptHeaderMustContainAtLeastOneValue;
        }

        $values->foreach(function(HeaderValue $value) {
            if (!$value instanceof AcceptValue) {
                throw new InvalidArgumentException;
            }
        });

        parent::__construct('Accept', $values);
    }
}
