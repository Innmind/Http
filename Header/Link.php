<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\{
    InvalidArgumentException,
    AcceptHeaderMustContainAtLeastOneValueException
};
use Innmind\Immutable\SetInterface;

final class Link extends Header
{
    public function __construct(SetInterface $values)
    {
        $values->foreach(function(HeaderValueInterface $value) {
            if (!$value instanceof LinkValue) {
                throw new InvalidArgumentException;
            }
        });

        parent::__construct('Link', $values);
    }
}
