<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\{
    InvalidArgumentException,
    AcceptRangesMustContainOnlyOneValueException
};
use Innmind\Immutable\SetInterface;

final class AcceptRanges extends Header
{
    public function __construct(SetInterface $values)
    {
        if ($values->size() !== 1) {
            throw new AcceptRangesMustContainOnlyOneValueException;
        }

        $values->foreach(function(HeaderValueInterface $value) {
            if (!$value instanceof AcceptRangesValue) {
                throw new InvalidArgumentException;
            }
        });

        parent::__construct('Accept-Ranges', $values);
    }
}
