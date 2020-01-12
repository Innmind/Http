<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\{
    Header\CacheControlValue,
    Exception\DomainException
};
use Innmind\Immutable\Str;

final class PrivateCache implements CacheControlValue
{
    private string $field;

    public function __construct(string $field)
    {
        if (!(new Str($field))->matches('~^\w*$~')) {
            throw new DomainException;
        }

        $this->field = $field;
    }

    public function field(): string
    {
        return $this->field;
    }

    public function toString(): string
    {
        return sprintf(
            'private%s',
            !empty($this->field) ? '="'.$this->field.'"' : ''
        );
    }
}
