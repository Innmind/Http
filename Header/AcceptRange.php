<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\{
    InvalidArgumentException,
    AcceptRangeMustContainOnlyOneValueException
};
use Innmind\Immutable\SetInterface;

final class AcceptRange extends Header
{
    public function __construct(SetInterface $values)
    {
        if ($values->size() !== 1) {
            throw new AcceptRangeMustContainOnlyOneValueException;
        }

        $values->foreach(function(HeaderValueInterface $value) {
            if (!$value instanceof AcceptRangeValue) {
                throw new InvalidArgumentException;
            }
        });

        parent::__construct('Accept', $values);
    }
}
