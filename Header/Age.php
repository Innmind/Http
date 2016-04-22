<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\{
    InvalidArgumentException,
    AgeMustContainOnlyOneValueException
};
use Innmind\Immutable\SetInterface;

final class Age extends Header
{
    public function __construct(SetInterface $values)
    {
        if ($values->size() !== 1) {
            throw new AgeMustContainOnlyOneValueException;
        }

        $values->foreach(function(HeaderValueInterface $value) {
            if (!$value instanceof AgeValue) {
                throw new InvalidArgumentException;
            }
        });

        parent::__construct('Age', $values);
    }
}
