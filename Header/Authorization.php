<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\{
    InvalidArgumentException,
    AuthorizationMustContainOnlyOneValueException
};
use Innmind\Immutable\SetInterface;

final class Authorization extends Header
{
    public function __construct(SetInterface $values)
    {
        if ($values->size() !== 1) {
            throw new AuthorizationMustContainOnlyOneValueException;
        }

        $values->foreach(function(HeaderValueInterface $value) {
            if (!$value instanceof AuthorizationValue) {
                throw new InvalidArgumentException;
            }
        });

        parent::__construct('Authorization', $values);
    }
}
